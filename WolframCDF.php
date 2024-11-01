<?php
/*
Plugin Name: WolframCDF
Plugin URI: http://www.dans-hobbies.com
Description: Simple plugin to insert CDF into the Wolfram Blog
Version: 2.1
Author: Dan Sherman
Author URI: http://www.wolfram.com
License: no license needed
*/

$wolframCDF = new WriCDF();

add_action( 'wp_enqueue_scripts', array($wolframCDF, 'includeScriptsAndCss'));
add_action('admin_print_scripts', array($wolframCDF, 'addshortCode'));
add_action('init', array($wolframCDF, 'addToTinyMCE'));

add_filter('upload_mimes', array($wolframCDF, 'addMimes'));
add_filter('the_content', array($wolframCDF, 'parseContent'));

class WriCDF{
    
    protected $_template = '';
    
    public function __construct(){
        $this->_template = '<div class="WolframCDF" style="text-align: center;"><script type="text/javascript">document.write(';
        $this->_template .= "'xx_altImage_xx'";
        $this->_template .= '); var WolframCDF = WolframCDF || new cdf_plugin(); WolframCDF.addCDFObject("xx_id_xx", "xx_source_xx", xx_width_xx, xx_height_xx);
                             </script>
                             <noscript>
                            <div style="margin: 0 auto; background-color:#ddd; width:xx_width_xxpx; height:xx_height_xxpx;"><div style="padding:10px; text-align:center; ">To view the full content of this page, please enable JavaScript in your browser.</div></div>
                            </noscript>
                            </div>';
    }
    
    public function includeScriptsAndCss(){
        wp_register_script('WolframCDFJs', plugin_dir_url(__FILE__).'cdfplugin.js', null, '2.0', false);
        wp_enqueue_script('WolframCDFJs');
        
    }
    
    public function addShortCode(){
        wp_enqueue_script('WolframCDFAdminJs', plugin_dir_url(__FILE__) . 'WolframCDF.js', array('quicktags'), '2.0');
    }
    
    public function addToTinyMCE(){
        if ((current_user_can('edit_posts') || current_user_can('edit_pages')) && get_user_option('rich_editing')){
            add_filter("mce_external_plugins", array($this, 'registerTinyMCEPluginFile'));
            add_filter('mce_buttons', array($this, 'registerTinyMCEPluginButton'));
        }
    }
    
    public function registerTinyMCEPluginButton($buttons){
        array_push($buttons, 'separator', 'WolframCDF');
        return $buttons;
    }
    
    public function registerTinyMCEPluginFile($plugins){
        $plugins['WolframCDF'] = plugin_dir_url(__FILE__) . 'WolframCDFTinyMCE.js';
        return $plugins;
    }
    
    public function addMimes($existing=array()){
        $existing['cdf'] = 'application/vnd.wolfram.cdf';
        $existing['nb'] = 'application/vnd.wolfram.mathematica';
        $existing['m'] = 'application/vnd.wolfram.mathematica.package';
        return $existing;
    }
    
    public function parseContent($content = ''){
        # A full cdf tags that need to be parsed look like the following.
        # [WolframCDF atributes list] or [WriCDF atributes list]
        
        $regex = '/(\[WriCDF [^\[]*\]|\[WolframCDF [^\[]*\])/';
        $newContent = preg_replace_callback($regex, array($this, '_parseShortCode'),$content);
        
        if($newContent !== null){
            return $newContent;
        }else{
            # something went wrong thus return the origonal content
            return $content;   
        }    
    }
    
    protected function _parseShortCodeAttribute($raw){
        $split = explode('=', $raw, 2);
        return array($split[0] => substr($split[1], 1, strlen($split[1])- 2));
    }
    
    protected function _parseShortCode($shortCode){
        $rawAttributes = null;
        $attributes = array();
        
        # this reg ex finds either of the following two attribute paterns attr='atr1' or attr="atr1"
        $regex = '#' . '([a-zA-Z0-9]*="[^"]*"' . '|' . "[a-zA-Z0-9]*='[^']*')" . '#' ;
        
        # get the raw short code attributes
        preg_match_all($regex, $shortCode[1], $rawAttributes);

        # process the raw attribues into key/value pairs
        foreach ($rawAttributes[1] AS $rawAttribute){   
            $attributes = array_merge($attributes, $this->_parseShortCodeAttribute($rawAttribute));
        }
        
        $isVersionZero = true;
        $versionZeroAttributes = array('width', 'height', 'source');
        foreach ($versionZeroAttributes AS $attribute){
            if(!array_key_exists($attribute, $attributes)){
                # doesn't have a version zero tag
                $isVersionZero = false;                  
            }   
        } 

        $isVersionOne = true;
        $versionOneAttributes = array('CDFwidth', 'CDFheight', 'source');
        foreach ($versionOneAttributes AS $attribute){
            if(!array_key_exists($attribute, $attributes)){
                # doesn't have a version one tag
                $isVersionOne = false;                  
            }   
        } 
        
        if(!$isVersionZero && !$isVersionOne){
            # its not based on version one or two shortcodes so just return what was passed in
            return $shortCode[1]; 
        }
        
        # clean up the attribues and homogenize them to be version two
        $finalAttributes = array();
        
        # check if an alterate image exists if so set it
        if(array_key_exists('altimage', $attributes) && $attributes['altimage'] != ''){
            # an alternate image exists so make the alt image 
            $before = '<div id="xx_id_xx" style="display: inline-block; margin: 0 auto;"><a style="display:block; width:xx_altImageWidth_xxpx; height:xx_altImageHeight_xxpx; background: url(';
            $before .= "\'";
            $after = "\'";
            $after .= ') no-repeat center center;" href="http://www.wolfram.com/cdf-player"></a></div>';
            
            $finalAttributes['altImage'] = $before . $attributes['altimage'] . $after;
        }else{
            # no alt image provided so make are own
            $before = '<div id="xx_id_xx" style="display: inline-block; margin: 0 auto;"><a style="display:block; width:xx_altImageWidth_xxpx; height:xx_altImageHeight_xxpx; background: #ddd url(';
            $before .= "\'";
            $after = "\'";
            $after .= ') no-repeat center center;" href="http://www.wolfram.com/cdf-player"></a></div>';
            
            $finalAttributes['altImage'] = $before . plugin_dir_url(__FILE__) . 'default.png'  . $after;
        }
        
        $finalAttributes['id']= 'CDF_' . sha1(mt_rand());
        
        if($isVersionZero){
            $finalAttributes['width'] = $attributes['width'];
            $finalAttributes['height'] = $attributes['height']; 
            $finalAttributes['source'] = $attributes['source'];    
        }
        
        if($isVersionOne){
            $finalAttributes['width'] = $attributes['CDFwidth'];
            $finalAttributes['height'] = $attributes['CDFheight']; 
            $finalAttributes['source'] = $attributes['source'];    
        }
        
        # set the alternate image width
        if(array_key_exists('altimagewidth', $attributes) && $attributes['altimagewidth'] != ''){
            $finalAttributes['altImageWidth'] = $attributes['altimagewidth'];
        }else{
            $finalAttributes['altImageWidth'] = $finalAttributes['width'];
        }
        
        # set the alternate image height
        if(array_key_exists('altimageheight', $attributes) && $attributes['altimageheight'] != ''){
            $finalAttributes['altImageHeight'] = $attributes['altimageheight'];
        }else{
            $finalAttributes['altImageHeight'] = $finalAttributes['height'];
        }        
        
        # everything looks good, so create the embed code and return it
        $return = $this->_template;
        
        //replace the template attributes with the actual ones
        foreach ($finalAttributes AS $key => $val){
            $return = str_replace('xx_' . $key . '_xx', $val, $return);
        } 
        
        return $return;
    }    
}
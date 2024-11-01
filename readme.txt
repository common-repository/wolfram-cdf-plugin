=== Plugin Name ===
Contributors: Wolfram Research
donate link: http://www.wolfram.com
Tags: CDF, Computable Document Format, Wolfram Research, Mathematica, Wolfram
Requires at least: 2.8.2
Tested up to: 3.5.1
Stable tag: 2.1


The Wolfram CDF Plugin is a simple robust plugin that allows users to place CDF Documents on their WordPress Blogs.

== Description ==
> The Wolfram CDF Plugin is no longer being updated. For embedding CDF documents on your WordPress site (via the cloud or plugin), Wolfram recommends the third-party plugin [Mathematica Toolbox](https://wordpress.org/plugins/mathematica-toolbox/ "Mathematica Toolbox").

The Wolfram CDF Plugin adds a CDF button to the WordPress HTML and visual post editors.

To use this plugin, open up a post you wish to edit. Click in the editor where you want the CDF content to be displayed and click the CDF button. Placeholder text will appear in the place of your selection.

The placeholder will appear as:
[WolframCDF source="" width="320" height="415" altimage="" altimagewidth="" altimageheight=""]

After editing the placeholder, click the Publish/Update post button or the Preview button to view the content, in order to confirm that the placeholder was parsed and replaced by the CDF. While some attributes must be set in order for your CDF to appear on the page, others are optional:

= source =
* Required: Yes
* Input type(s): file name with extension, url
* Description: 'source' holds the CDF file name or the url where the file is located. To enter just the file's name, you must first add the file to WordPress using the file uploader.

= width =
* Required: Yes
* Input type(s): integer
* Description: 'width' holds an integer that describes the width in pixels of the CDF on your WordPress blog.

= height =
* Required: Yes
* Input type(s): integer
* Description: 'height' holds an integer that describes the height in pixels of the CDF on your WordPress blog.

= altimage =
* Required: No
* Input type(s): file name with extension, url
* Description: 'altimage' stores an image that will be displayed if the client does not have the CDF plugin installed. If left blank, a generic placeholder will appear.

= altimagewidth =
* Required: No
* Input type(s): integer
* Description: 'altimagewidth' holds an integer that describes the width in pixels of the alternate image, which may be different than the width of the CDF itself.

= altimageheight =
* Required: No
* Input type(s): integer
* Description: 'altimageheight' holds an integer that describes the height in pixels of the alternate image, which may be different than the height of the CDF itself.

When using Mathematica 9.0.1 (or higher), you can use the CDF Deployment Wizard (http://www.wolfram.com/cdf/adopting-cdf/deploying-cdf/) to generate your individual CDF files and alt images. The generated alt image includes an overlaid CDF Player logo, and when a user clicks on the image, they are taken to the download site for the CDF plugin. Once installed, the alt image disappears and the interactive CDF content is displayed.


== Installation ==

= Automatic =
1. Download the zip file of the plugin which can be found by going to http://wordpress.org/extend/plugins/ and searching for
CDF.
2. Log in to the admin pages of your site and click on Plugins->Add New->Upload.  Then brows for the zip file you downloaded
and press Install Now.
3. Click on the 'installed' link under 'Plugins' and activate the Wolfram CDF Plugin.

= Manual =
1. Download the zip file of the plugin which can be found by going to http://wordpress.org/extend/plugins/ and searching for
CDF.
2. Upload the zip file to the `/wp-content/plugins/` directory
3. Log in to the wp-admin page of your wordpress blog.
4. Click on Plugins->Installed and activate the Wolfram CDF Plugin.

== Frequently Asked Questions ==

= What does CDF Stand for? =

Computable Document Format

= How do I create CDF documents? =
You create CDF documents through a probram called Mathematica.  For more information please please visit
http://www.wolfram.com/mathematica/

= How do I publish A CDF document to my site without this plugin? =
For information on this topic please visit http://www.wolfram.com/cdf/adopting-cdf/deploying-cdf/web-delivery.html

= Do I have to use the altimage fields? =
No. If you do not fill in an altimage, a gray box will appear with a link to download the CDF plugin.

= Why is my altimage resized? How can I stop this from happening? =
If nothing is given for the altimageheight and altimagewidth fields, the image will appear at the size of the CDF itself. When you enter values for altimageheight and altimagecontent, the image will take on those dimensions.

== Screenshots ==

1. screenshot-1.png shows the the the input to the html editor in wp-admin.
2. screenshot-2.png shows the outcome of screenshot-1.png.

== Changelog ==

= 2.1 =
* Fixed a bug specific to Firefox and Chrome On Mac.

= 2.0 =
* Removed altcont support, as it was not really used and was not as flexible as it could be.
* Streamlined the altimage functionality as well as added optional parameters (altimagewidth, altimageheight) to size the image independently of the CDF.
* Added a quick tag button to the visual editor.
* Removed the use of a template file to make the plugin more system I/O efficient.

= 1.2 =
* Improved integration with WordPress media uploader.

= 1.0 =
* Added altcont and altimage attributes.
* Allowed for file name only to be entered into the source attribute.

= 0.5 =
* Original version.
* Internal only.

== Upgrade Notice ==

= 2.1 =
Version 2.1 allows you to add CDF Documents to you WordPress Blog.
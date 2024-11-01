(function() {
        tinymce.create('tinymce.plugins.WolframCDF', {
                init : function(ed, url) {
                        ed.addButton('WolframCDF', {
                                title : 'WolframCDF',
                                cmd : 'mceExample',
                                image : url + '/tinyMCEbutton.png',
                                onclick : function() {
                                    ed.selection.setContent('[WolframCDF source="" width="320" height="415" altimage="" altimagewidth="" altimageheight=""]');
                                }
                        });
                },

                getInfo : function() {
                        return {
                                longname : 'Wolfram CDF',
                                author : 'Daniel Sherman',
                                authorurl : 'http://www.wolfram.com',
                                infourl : 'http://www.wolfram.com',
                                version : "2.0"
                        };
                }
        });

        tinymce.PluginManager.add('WolframCDF', tinymce.plugins.WolframCDF);
})();
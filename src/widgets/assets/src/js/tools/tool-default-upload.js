/*!
* @author Semenov Alexander <semenov@skeeks.com>
* @link http://skeeks.com/
* @copyright 2010 SkeekS (СкикС)
* @date 27.04.2017
*/
(function(sx, $, _)
{
    /**
     *
     */
    sx.classes.fileupload.tools.DefaultUploadTool = sx.classes.fileupload.tools._Tool.extend({

        _init: function()
        {

        },

        _onDomReady: function()
        {
            var self = this;

            this.JInput = $('#' + this.get('id'));

            jQuery(this.JInput).fileupload();

            jQuery(this.JInput).on('fileuploadadd', function(e, data) {
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('fileuploaddone', function(e, data) {
                var result = data.result.data;
                $("<img>", {
                    'src' : result.publicPath,
                    'style' : 'max-width: 80px; max-height: 80px;'
                }).appendTo(self.jFiles);
                self.jInputHidden.val(result.rootPath);
                self.jInputHidden.change();
            });
        },

    });

})(sx, sx.$, sx._);
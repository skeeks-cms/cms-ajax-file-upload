/*!
* @author Semenov Alexander <semenov@skeeks.com>
* @link http://skeeks.com/
* @copyright 2010 SkeekS (СкикС)
* @date 27.04.2017
*/
(function(sx, $, _)
{
    sx.createNamespace('classes.fileupload', sx);

    /**
     * Files upload tool
     */
    sx.classes.fileupload._File = sx.classes.Component.extend({

        /**
         * @param AjaxFileUpload
         * @param opts
         */
        construct: function(AjaxFileUpload, opts)
        {
            var self = this;

            if (! (AjaxFileUpload instanceof sx.classes.fileupload.AjaxFileUpload))
            {
                throw new Error('Upload manager not uploaded');
            }

            opts = opts || {};
            opts['Uploader'] = AjaxFileUpload;

            this.applyParentMethod(sx.classes.Component, 'construct', [opts]);
        },


        render: function()
        {
            console.log(this);
            this.JWrapper = $('<div>', {'class': 'col-md-4 sx-file-not-uploaded'});
            this.JCaption = $('<div>', {'class': 'caption'});
            this.JThumbWrapper = $('<div>', {'class' : 'thumbnail sx-box-shadow sx-box-shadow-hover-color'});
            this.JImgPrev = $('<div>', {'class' : 'img-preview'});
            this.JResult = $('<div>', {'class' : 'sx-result'}).append('Ожидание...');

            this.JCaption
                .append($('<h4>', {'title' : this.get('fileinfo').name}).text(this.get('fileinfo').name))
                .append(this.JResult);


            this.JWrapper.append(this.JThumbWrapper);
            this.JThumbWrapper.append(this.JImgPrev).append(this.JCaption);
        }
    });

    sx.classes.fileupload.File = sx.classes.fileupload._File.extend();

})(sx, sx.$, sx._);
/*!
* @author Semenov Alexander <semenov@skeeks.com>
* @link http://skeeks.com/
* @copyright 2010 SkeekS (СкикС)
* @date 27.04.2017
*/
(function(sx, $, _)
{
    /**
     * Стандартная ajax загрузка файлов
     */
    sx.classes.fileupload.tools.DefaultUploadTool = sx.classes.fileupload.tools._Tool.extend({

        run: function()
        {
            this.JInput.click();
        },

        _onDomReady: function()
        {
            var self = this;

            this.JInput = $('#' + this.get('id'));

            jQuery(this.JInput).fileupload(this.get('uploadfile'));

            jQuery(this.JInput).on('fileuploadadd', function(e, data) {

                var FileObject = new sx.classes.fileupload.File(self.Uploader);

                $.each(data.files, function (index, file) {

                    FileObject.set('fileinfo', file);
                });

                data.context = FileObject;

                self.Uploader.addFile(FileObject);
            });

            jQuery(this.JInput).on('fileuploadprocessalways', function(e, data) {
                var FileObject = data.context;

                var index = data.index,
                file = data.files[index];

                if (file.preview) {
                    FileObject.JImgPrev.append(file.preview);
                }

                if (file.error) {

                    FileObject.JResult.empty().append(file.error);
                }
            });

            jQuery(this.JInput).on('fileuploadprogressall', function(e, data) {
                console.log("fileuploadprogressall");
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('fileuploaddone', function(e, data) {
                console.log(data.result);
                var FileObject = data.context;

                if (data.result.success === true)
                {
                    FileObject.JResult.empty().append("ОК");
                } else
                {
                    FileObject.JResult.empty().append("<span style='color: red;'>" + data.result.message + "</span>");
                }

                FileObject.JWrapper.removeClass('sx-file-process').addClass('sx-file-success');

                $.each(data.result.files, function (index, file) {
                    if (file.url) {
                        var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                        $(data.context.children()[index])
                            .wrap(link);
                    } else if (file.error) {
                        var error = $('<span class="text-danger"/>').text(file.error);
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    }
                });
            });

            jQuery(this.JInput).on('fileuploadsubmit', function(e, data) {
                console.log("fileuploadsubmit");
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('fileuploadsend', function(e, data) {
                var FileObject = data.context;
                FileObject.JWrapper.removeClass('sx-file-not-uploaded').addClass('sx-file-process');
                FileObject.JResult.empty().append("<img src='/img/loaders/default-124.svg' height='20'/>").append(" Загрузка...");
            });

            jQuery(this.JInput).on('fileuploadprocess', function(e, data) {
                console.log("fileuploadprocess");
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('fileuploadstart', function(e, data) {
                console.log("fileuploadstart");
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('fileuploadstop', function(e, data) {
                console.log("fileuploadstop");
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('fileuploadfail', function(e, data) {
                var FileObject = data.context;
                FileObject.JResult.empty().append("Ошибка");

                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                });
            });

            jQuery(this.JInput).on('paste', function(e, data) {
                console.log("paste");
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('drop', function(e, data) {
                console.log("drop");
                console.log(e);
                console.log(data);
            });

            jQuery(this.JInput).on('dragover', function(e, data) {
                console.log("dragover");
                e.preventDefault(); // Prevents the default dragover action of the File Upload widget
                console.log(e);
                console.log(data);
            });

            /*jQuery(this.JInput).on('fileuploaddone', function(e, data) {
                var result = data.result.data;
                $("<img>", {
                    'src' : result.publicPath,
                    'style' : 'max-width: 80px; max-height: 80px;'
                }).appendTo(self.jFiles);
                self.jInputHidden.val(result.rootPath);
                self.jInputHidden.change();
            });*/
        },

    });

})(sx, sx.$, sx._);
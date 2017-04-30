/*!
* @author Semenov Alexander <semenov@skeeks.com>
* @link http://skeeks.com/
* @copyright 2010 SkeekS (СкикС)
* @date 27.04.2017
*/
(function(sx, $, _)
{
    /**
     * Удаленная загрузка файлов
     */
    sx.classes.fileupload.tools.RemoteUploadTool = sx.classes.fileupload.tools._Tool.extend({

        run: function()
        {
            var self = this;
            //По клику на кнопку, загрузить по http, рисуем textarea, предлагаем ввести пользователю ссылки на изображения, которые хотим скачать, резделив их через запятую или с новой строки.
            //По нажатию кнопки начало загрузки.
            sx.prompt("Введите URL файла", {
                'yes': function (e, result)
                {
                    self._processing(result);
                }
            });
        },

        _processing: function(link)
        {
            var self = this;
            //1) считаем сколько всего пользователь указал ссылок (это делается на js)
            this.httpLinks = [link];

            //Берем каждую, и обрабатываем по очереди.
            _.each(this.httpLinks, function (link, key) {
                //Кидаем событие, начало работы с файлом
                var FileObject = new sx.classes.fileupload.File(self.Uploader);

                FileObject.set('name', link);
                FileObject.set('state', 'queue');
                FileObject.set('state', 'process');

                self.Uploader.appendFile(FileObject);

                var ajax = sx.ajax.preparePostQuery(self.get('upload_url'), {
                    'link': link
                });

                ajax.onComplete(function (e, data)
                {
                    FileObject.set('state', 'success');
                    /*self.triggerCompleteUploadFile({
                        'response': data.jqXHR.responseJSON
                    });*/
                });

                ajax.execute();
            });
        }
    });

})(sx, sx.$, sx._);
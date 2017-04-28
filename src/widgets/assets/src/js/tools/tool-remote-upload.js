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
            sx.prompt("Введите URL файла начиная с http://", {
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

            self.queue = _.size(this.httpLinks);   //В очереди к загрузки осталось столько то файлов
            self.inProcess = true;                     //Загрузчик в работе

            self.triggerStartUpload({
                'queueLength': _.size(this.httpLinks) //сообщаем сколько файлов к загрузке всего
            });

            //Берем каждую, и обрабатываем по очереди.
            _.each(this.httpLinks, function (link, key) {
                //Кидаем событие, начало работы с файлом
                self.triggerStartUploadFile({
                    'name': link,      //ссылка к загрузке
                    'additional': {}  //дополнительная информация
                });

                var ajaxData = _.extend(self.getManager().getCommonData(), {
                    'link': link
                });

                var ajax = sx.ajax.preparePostQuery(self.get('url'), ajaxData);

                ajax.onComplete(function (e, data)
                {
                    self.triggerCompleteUploadFile({
                        'response': data.jqXHR.responseJSON
                    });

                    self.queue = self.queue - 1;

                    if (self.queue == 0)
                    {
                        self.inProcess = false;
                        self.triggerCompleteUpload({});
                    }
                });

                ajax.execute();
            });
        }
    });

})(sx, sx.$, sx._);
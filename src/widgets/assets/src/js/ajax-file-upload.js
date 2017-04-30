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
     * Виджет загурзки файлов
     */
    sx.classes.fileupload.AjaxFileUpload = sx.classes.Component.extend({

        _init: function()
        {
            var self    = this;
            //Инструменты загрузки
            this.Tools  = [];
            this.Files  = [];
        },

        _onDomReady: function()
        {
            var self = this;
            
            this.JFiles = $(".sx-files", this.getJWrapper());
            this.JTools = $(".sx-tools", this.getJWrapper());
            
            //Запуск инструмента загрузки
            this.JRunToolBtn = $(".sx-run-tool", this.getJWrapper());
            this.JRunToolBtn.on('click', function()
            {
                var id = $(this).data('tool-id');
                var Tool = self.getTool(id);
                if (!Tool || !Tool instanceof sx.classes.fileupload.tools._Tool)
                {
                    throw new Error('Tool not found or bad: ' + id);
                    return false;
                }
                Tool.run();
                return false;
            });
        },

        /**
         * @returns {*}
         */
        getJWrapper: function()
        {
            return $("#" + this.get('id'));
        },

        /**
         * @param id
         * @returns {null}
         */
        getTool: function(id)
        {
            return _.find(this.Tools, function(Tool)
            {
                return Tool.get('id') == id;
            });
            
            return null;
        },

        /**
         * @returns {*}
         */
        getFileStates: function()
        {
            return new sx.classes.Entity( this.get('fileStates') );
        },

        /**
         * @param File
         * @returns {sx.classes.fileupload.AjaxFileUpload}
         */
        addFile: function(File)
        {
            this.Files.push(File);
            this.JFiles.append(File.render());
            return this;
        }
    });

})(sx, sx.$, sx._);
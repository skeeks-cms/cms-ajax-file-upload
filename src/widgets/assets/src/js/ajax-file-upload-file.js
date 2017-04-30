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

            this.isUploaded = false;

            if (! (AjaxFileUpload instanceof sx.classes.fileupload.AjaxFileUpload))
            {
                throw new Error('Upload manager not uploaded');
            }

            opts = opts || {};
            this.Uploader = AjaxFileUpload;

            this.applyParentMethod(sx.classes.Component, 'construct', [opts]);
        },


        /**
         * @private
         */
        _onDomReady: function()
        {
            var self = this;
            this.JWrapper = $('<div>', {'class': 'col-md-3'});


        },




        /**
         * Расшифровка состояния
         * @returns {*}
         */
        getStateText: function () {

            var states = this.Uploader.getFileStates();
            return states.get( this.getState(), 'Не определен' );
        },

        /**
         * Код состояния
         * @returns {string}
         */
        getState: function()
        {
            return String(this.get('state', 'undefined'));
        },

        /**
         * @returns {string}
         */
        getName: function()
        {
            return String(this.get('name', 'undefined'));
        },

        /**
         * @returns {string}
         */
        getError: function()
        {
            return this.get('error');
        },

        /**
         * @returns {string}
         */
        getPreview: function()
        {
            return this.get('preview');
        },

        /**
         * @returns {string}
         */
        getValue: function()
        {
            return String(this.get('value'));
        },

        /**
         * @returns {*|HTMLElement}
         */
        render: function()
        {
            this.JCaption       = $('<div>', {'class' : 'caption'});
            this.JThumbWrapper  = $('<div>', {'class' : 'thumbnail'});
            this.JFilePrev       = $('<div>', {'class' : 'file-preview'});
            this.JResult        = $('<div>', {'class' : 'sx-result'}).append(this.getStateText());

            this.JCaption
                .append($('<h4>', {'title' : this.getName()}).text(this.getName()))
                .append(this.JResult);

            this.JThumbWrapper.append(this.JFilePrev).append(this.JCaption);

            if (this.getError())
            {
                console.log('error');
                console.log(this.getError());
                this.JResult.empty().append(this.getError());
            }

            if (this.getPreview())
            {
                this.JFilePrev.empty().append(this.getPreview());
            }

            this.JWrapper
                .removeClass('sx-state-queue')
                .removeClass('sx-state-process')
                .removeClass('sx-state-success')
                .removeClass('sx-state-fail')
                .addClass('sx-state-' + this.getState());

            this.JWrapper.empty().append(this.JThumbWrapper);
            return this.JWrapper;
        }
    });

    sx.classes.fileupload.File = sx.classes.fileupload._File.extend();

})(sx, sx.$, sx._);
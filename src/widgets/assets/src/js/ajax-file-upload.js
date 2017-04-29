/*!
* @author Semenov Alexander <semenov@skeeks.com>
* @link http://skeeks.com/
* @copyright 2010 SkeekS (СкикС)
* @date 27.04.2017
*/
(function(sx, $, _)
{
    sx.createNamespace('classes.fileupload', sx);

    sx.classes.fileupload.AjaxFileUpload = sx.classes.Component.extend({

        _init: function()
        {
            var self = this;
        },

        _onDomReady: function()
        {

        },

        /**
         * @returns {*}
         */
        getJWrapper: function()
        {
            return this.get('tools');
        },

        /**
         * @returns {*}
         */
        getTools: function()
        {
            return this.get('tools');
        }
    });

})(sx, sx.$, sx._);
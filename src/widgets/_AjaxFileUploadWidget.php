<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 26.04.2017
 */

namespace skeeks\cms\fileupload\widgets;
use dosamigos\fileupload\FileUpload;
use dosamigos\fileupload\FileUploadAsset;
use dosamigos\fileupload\FileUploadPlusAsset;
use skeeks\cms\models\CmsStorageFile;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * @property CmsStorageFile $cmsFile
 *
 * Class AjaxFileUploadWidget
 * @package skeeks\cms\widgets\fileupload
 */
class AjaxFileUploadWidget extends FileUpload
{
    public $viewFile        = 'ajax-file-upload';
    public $url             = '/site/upload';

    public $plus            = true;

    public $clientEvents    = [];
    public $hiddenOptions   = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->options['id'] = $this->id . "-file";
        $fileInput =  Html::fileInput('file', '', $this->options);
        $this->hiddenOptions['id'] = $this->id . "-hidden";
        $hiddenInput = $this->hasModel()
            ? Html::activeHiddenInput($this->model, $this->attribute, $this->hiddenOptions)
            : Html::hiddenInput($this->name, $this->value, $this->hiddenOptions);
        echo $this->render($this->viewFile, [
            'fileInput'         => $fileInput,
            'hiddenInput'       => $hiddenInput
        ]);
        $this->registerClientScript();
    }
    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        if($this->plus) {
            FileUploadPlusAsset::register($view);
        } else {
            FileUploadAsset::register($view);
        }
        $id = $this->options['id'];
        $jsOptions = Json::encode([
            'id'            => $this->id,
            'inputId'       => $id,
            'hiddenId'       => $this->hiddenOptions['id'],
            'clientOptions' => $this->clientOptions
        ]);
        $this->view->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.Uploader = sx.classes.Component.extend({
        _init: function()
        {},
        _onDomReady: function()
        {
            var self = this;
            this.jInput = $('#' + this.get('inputId'));
            this.jInputHidden = $('#' + this.get('hiddenId'));
            this.jWrapper = $('#' + this.get('id'));
            this.jFiles = $('.sx-files', this.jWrapper);
            this.jRemoveBtn = $('.sx-btn-remove-file', this.jWrapper);

            jQuery(this.jInput).fileupload(this.get('clientOptions'));
            jQuery(this.jInput).on('fileuploadadd', function(e, data) {
                self.jFiles.empty().append('Подождите идет загрузка...');
            });
            jQuery(this.jRemoveBtn).on('click', function(e, data) {
                self.jFiles.empty();
                self.jInputHidden.val("");
                self.jInputHidden.change();
            });
            jQuery(this.jInput).on('fileuploaddone', function(e, data) {
                self.jFiles.empty().append();
                var result = data.result.data;
                $("<img>", {
                    'src' : result.publicPath,
                    'style' : 'max-width: 80px; max-height: 80px;'
                }).appendTo(self.jFiles);
                self.jInputHidden.val(result.rootPath);
                self.jInputHidden.change();
            });
        }
    });
    new sx.classes.Uploader({$jsOptions});
})(sx, sx.$, sx._);
JS
);
        $js[] = "";
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
        }
        $view->registerJs(implode("\n", $js));
    }

    /**
     * @return null|CmsStorageFile
     */
    public function getCmsFile()
    {
        if ($fileId = $this->model->{$this->attribute})
        {
            return CmsStorageFile::findOne((int) $fileId);
        }

        return null;
    }
}
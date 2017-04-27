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
use skeeks\cms\fileupload\FileUploadModule;
use skeeks\cms\models\CmsStorageFile;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * @property CmsStorageFile $cmsFile
 *
 * Class AjaxFileUploadWidget
 * @package skeeks\cms\widgets\fileupload
 */
class AjaxFileUploadWidget extends InputWidget
{
    public $view_file        = 'ajax-file-upload';

    public $upload_url      = ['/fileupload/upload'];

    public $multiple        = false;

    public $sources         = [

    ];

    public function init()
    {
        FileUploadModule::registerTranslations();

        $this->options['id']        = $this->id . "-widget";
        $this->clientOptions['id']  = $this->id . "-widget";

        $this->options['multiple'] = $this->multiple;
    }

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
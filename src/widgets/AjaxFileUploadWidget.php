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
use skeeks\cms\fileupload\widgets\assets\AjaxFileUploadWidgetAsset;
use skeeks\cms\models\CmsStorageFile;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * @property CmsStorageFile $cmsFile
 * @property AjaxFileUploadDefaultTool|AjaxFileUploadTool $defaultTool
 *
 * Class AjaxFileUploadWidget
 * @package skeeks\cms\widgets\fileupload
 */
class AjaxFileUploadWidget extends InputWidget
{
    public static $autoIdPrefix = 'AjaxFileUploadWidget';

    public $view_file        = 'ajax-file-upload';

    public $upload_url      = ['/fileupload/upload'];

    public $multiple        = false;

    /**
     * @var AjaxFileUploadDefaultTool[]
     */
    public $tools         = [

        'default' =>
        [
            'class' => AjaxFileUploadDefaultTool::class,
            'name' => 'Загрузить',
            'icon' => 'glyphicon glyphicon-download-alt',
        ],

        'remote' =>
        [
            'class' => AjaxFileUploadDefaultTool::class,
            'name' => 'Загрузить по ссылке',
            'icon' => 'glyphicon glyphicon-globe',
        ]
    ];

    public $clientOptions         = [];

    public function init()
    {
        FileUploadModule::registerTranslations();

        //$this->options['id']        = $this->id . "-widget";
        //$this->clientOptions['id']  = $this->id . "-widget";

        $this->options['multiple'] = $this->multiple;

        $tools = [];

        foreach ($this->tools as $id => $config)
        {
            $config['id'] = $id;
            $config['ajaxFileUploadWidget'] = $this;
            $tool = \Yii::createObject($config);
            $tools[$id] = $tool;
        }

        $this->tools = $tools;

        if (!$this->tools)
        {
            throw new InvalidConfigException('Not configurated file upload tools');
        }


    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $element = $this->hasModel()
            ? Html::activeHiddenInput($this->model, $this->attribute, $this->options)
            : Html::hiddenInput($this->name, $this->value, $this->options);

        echo $this->render($this->view_file, [
            'element'         => $element,
        ]);
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

    /**
     * @return AjaxFileUploadDefaultTool
     */
    public function getDefaultTool()
    {
        return reset($this->tools);
    }
}
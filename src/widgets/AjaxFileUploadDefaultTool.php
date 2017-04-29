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
use skeeks\cms\fileupload\widgets\assets\AjaxFileUploadDefaultToolAsset;
use skeeks\cms\models\CmsStorageFile;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * Class AjaxFileUploadDefaultTool
 *
 * @package skeeks\cms\fileupload\widgets
 */
class AjaxFileUploadDefaultTool extends AjaxFileUploadTool
{
    public $options = [];
    public $clientOptions = [];
    public $url = null;

    public function init()
    {
        parent::init();

        $this->id = $this->ajaxFileUploadWidget->id . "-" . $this->id;

        $url = Url::to($this->url);
        $this->options['id'] = $this->id;
        $this->options['data-url'] = $url;

        $this->clientOptions['id'] = $this->id;
    }

    public function run()
    {
        AjaxFileUploadDefaultToolAsset::register($this->ajaxFileUploadWidget->view);

        $js = Json::encode($this->clientOptions);
        $this->ajaxFileUploadWidget->view->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.fileupload.tools.DefaultUploadTool(sx.{$this->ajaxFileUploadWidget->id}, {$js});
})(sx, sx.$, sx._);
JS
);
        return Html::fileInput($this->id, '', $this->options);
    }


}
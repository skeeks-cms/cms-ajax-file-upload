<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 27.04.2017
 */
namespace skeeks\cms\fileupload\widgets\assets;
use dosamigos\fileupload\FileUpload;
use dosamigos\fileupload\FileUploadAsset;
use dosamigos\fileupload\FileUploadPlusAsset;
use skeeks\cms\base\AssetBundle;
use skeeks\cms\models\CmsStorageFile;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class AjaxFileUploadDefaultToolAsset
 * @package skeeks\cms\fileupload\widgets\assets
 */
class AjaxFileUploadRemoteToolAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/fileupload/widgets/assets/src';

    public $css = [];

    public $js = [
        'js/tools/tool-remote-upload.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'dosamigos\fileupload\FileUploadPlusAsset',
        'skeeks\cms\fileupload\widgets\assets\AjaxFileUploadWidgetAsset',
    ];
}
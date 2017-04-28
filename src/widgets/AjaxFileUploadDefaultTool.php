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
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Class AjaxFileUploadDefaultTool
 *
 * @package skeeks\cms\fileupload\widgets
 */
class AjaxFileUploadDefaultTool extends AjaxFileUploadTool
{
    public function init()
    {
        parent::init();
    }
}
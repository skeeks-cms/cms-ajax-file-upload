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
use skeeks\cms\IHasInfo;
use skeeks\cms\models\CmsStorageFile;
use skeeks\cms\traits\THasInfo;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Class AjaxFileUploadTool
 *
 * @package skeeks\cms\fileupload\widgets
 */
abstract class AjaxFileUploadTool extends Widget
    implements IHasInfo
{
    use THasInfo;

    /**
     * @var AjaxFileUploadWidget
     */
    public $ajaxFileUploadWidget = null;

    /**
     * @var null
     */
    public $id = null;

    public function init()
    {
        parent::init();

        if (!$this->ajaxFileUploadWidget || !$this->ajaxFileUploadWidget instanceof AjaxFileUploadWidget)
        {
            throw new InvalidConfigException();
        }
    }
}
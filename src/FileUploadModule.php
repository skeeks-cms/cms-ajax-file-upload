<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 26.04.2017
 */
namespace skeeks\cms\fileupload;
/**
 * Class Module
 * @package skeeks\modules\cms\form2
 */
class FileUploadModule extends \yii\base\Module
{
    public $controllerNamespace = 'skeeks\cms\fileupload\controllers';

    public function init()
    {
        parent::init();
        self::registerTranslations();
    }

    static public $isRegisteredTranslations = false;

    static public function registerTranslations()
    {
        if (self::$isRegisteredTranslations === false)
        {
            \Yii::$app->i18n->translations['skeeks/cms-fileupload'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@skeeks/cms/fileupload/messages',
                'fileMap' => [
                    'skeeks/cms-fileupload' => 'main.php',
                ],
                //'on missingTranslation' => \Yii::$app->i18n->missingTranslationHandler
            ];
            self::$isRegisteredTranslations = true;
        }
    }
}

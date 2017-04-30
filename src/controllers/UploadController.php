<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 29.04.2017
 */

namespace skeeks\cms\fileupload\controllers;

use common\models\User;
use skeeks\cms\actions\LogoutAction;
use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\vkDatabase\models\VkCity;
use Yii;
use skeeks\module\cms\user\model\LoginForm;
use skeeks\module\cms\user\model\PasswordResetRequestForm;
use skeeks\module\cms\user\model\ResetPasswordForm;
use skeeks\module\cms\user\model\SignupForm;
use frontend\models\ContactForm;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class UploadController
 *
 * @package skeeks\cms\fileupload\controllers
 */
class UploadController extends Controller
{
    public $defaultAction = 'upload';

    public $local_root_tmp_dir = '@frontend/web/assets/temp';
    public $local_public_tmp_dir = '/assets/temp';
    /**
     * @return RequestResponse
     * @throws Exception
     */
    public function actionUpload()
    {
        //sleep(5);
        $rr = new RequestResponse();
        try
        {
            $file = UploadedFile::getInstanceByName(\Yii::$app->request->post('formName'));

            $uid = uniqid(time(), true);
            $directory = \Yii::getAlias($this->local_root_tmp_dir) . DIRECTORY_SEPARATOR . $uid . DIRECTORY_SEPARATOR;
            if (!is_dir($directory))
            {
                FileHelper::createDirectory($directory);
            }

            if (!is_dir($directory))
            {
                throw new Exception(\Yii::t('app', 'Could not create a directory for download'));
            }

            if ($file)
            {
                $filePath = $directory . $file->name;
                if (!$file->saveAs($filePath))
                {
                    throw new Exception(\Yii::t('app', 'Could not upload the image to a local folder'));
                }
                $path = $this->local_public_tmp_dir . '/' . $uid . "/" . $file->name;
                $rr->success = true;
                $rr->data = [
                    'name'          =>  $file->name,
                    'size'          =>  $file->size,
                    "src"           =>  $path,
                    "rootPath"      =>  $filePath,
                ];
            }

        } catch (\Exception $e)
        {
            \Yii::error($e->getMessage(), 'uploader');
            $rr->message = $e->getMessage();
            $rr->success = false;
        }

        return $rr;
    }
}

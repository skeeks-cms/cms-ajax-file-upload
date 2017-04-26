<?php
/** @var \dosamigos\fileupload\FileUpload $this */
/** @var string $input the code for the input */
/* @var $this yii\web\View */
$widget = $this->context;
?>
<div class="sx-uploader-wrapper" id="<?= $widget->id; ?>">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn btn-default fileinput-button" style="float: left;">
               <i class="glyphicon glyphicon-plus"></i>
               <span>Выбрать файл</span>
               <!-- The file input field used as target for the file upload widget -->
                <?= $fileInput ?>
                <?= $hiddenInput ?>
            </div>
            <div class="sx-files" style="float: left; margin-left: 10px;">
                <? if ($widget->cmsFile): ?>
                    <img src="<?= $widget->cmsFile->src; ?>" style="max-width: 80px; max-height: 80px;"/>
                <? endif; ?>
                <a href="#" class="btn btn-xs btn-default sx-btn-remove-file" title="Удалить">x</a>
            </div>
        </div>
    </div>
</div>
<?php
/** @var \skeeks\cms\fileupload\widgets\AjaxFileUploadWidget $widget */
/** @var string $input the code for the input */
/* @var $this yii\web\View */
$widget = $this->context;
?>
<div class="sx-ajax-file-uploader-wrapper dropzone" id="<?= $widget->id; ?>">
    <div class="row">

        <div class="col-sm-12 sx-files" style="float: left; margin-left: 10px;">
            <div class="sx-file">
                <? if ($widget->cmsFile): ?>
                    <img src="<?= $widget->cmsFile->src; ?>" style="max-width: 80px; max-height: 80px;"/>
                <? endif; ?>
                <a href="#" class="btn btn-xs btn-default sx-btn-remove-file" title="Удалить">x</a>
            </div>
        </div>

        <div class="col-sm-12 sx-tools">
            <div class="btn-group">
              <button type="button" class="btn btn-default fileinput-button sx-run-tool" data-tool-id="<?= $widget->defaultTool->id; ?>">
                  <i class="<?= $widget->defaultTool->icon; ?>"></i> <?= $widget->defaultTool->name; ?>
              </button>
              <? if (count($widget->tools) > 1) : ?>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdow</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                      <? foreach ($widget->tools as $tool) : ?>
                          <li><a href="#" class="sx-run-tool" data-tool-id="<?= $tool->id; ?>"><i class="<?= $tool->icon; ?>"></i> <?= $tool->name; ?></a></li>
                      <? endforeach; ?>
                  </ul>
              <? endif; ?>
            </div>
        </div>

        <div style="display: none;">
            <?= $element ?>
        </div>
<?
\skeeks\cms\fileupload\widgets\assets\AjaxFileUploadWidgetAsset::register($this);
$js = \yii\helpers\Json::encode($widget->clientOptions);

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.{$widget->id} = new sx.classes.fileupload.AjaxFileUpload({$js});
})(sx, sx.$, sx._);
JS
);
?>

        <div style="display: none;">
            <? foreach ($widget->tools as $tool) : ?>
                  <?= $tool->run(); ?>
              <? endforeach; ?>
        </div>

    </div>
</div>

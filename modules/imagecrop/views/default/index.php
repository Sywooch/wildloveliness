<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\filemanager\assets\FilemanagerAsset;

$filemngrAsset = FilemanagerAsset::register($this);
?>


<img id="photo" src="/web/uploads/1/2-1/3029555_stock_photo_pirate_flag_.jpg" alt="Some image description" />



<div class="imagecrop-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>

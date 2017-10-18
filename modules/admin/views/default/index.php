<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="admin-default-index">
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

    <?= Html::a('Производители', ['/admin/cat']); ?>

    <h3>Справочники</h3>
    <?= Html::a('Титулы', ['/admin/titles']); ?>
    <?= Html::a('Окрасы', ['/admin/colors']); ?>

</div>

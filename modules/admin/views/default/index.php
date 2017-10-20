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
    <?= Html::a('Пометы', ['/admin/litter']); ?>

    <h3>Справочники</h3>
    <?= Html::a('Титулы WCF', ['/admin/titles']); ?><br>
    <?= Html::a('Окрасы кошек', ['/admin/colors']); ?><br>
    <?= Html::a('Статусы доступности', ['/admin/colors']); ?>

</div>

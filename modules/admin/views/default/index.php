<?php
use yii\helpers\Html;
?>

<div class="admin-default-index">
    <h1>Панель управления</h1>

    <?= Html::a('Производители', ['/admin/cat']); ?><br>
    <?= Html::a('Пометы', ['/admin/litter']); ?><br>
    <?= Html::a('Котята', ['/admin/kitten']); ?><br>

    <h3>Справочники</h3>
    <?= Html::a('Титулы WCF', ['/admin/title']); ?><br>
    <?= Html::a('Окрасы кошек', ['/admin/color']); ?><br>
    <?= Html::a('Статусы котят', ['/admin/status']); ?>

</div>

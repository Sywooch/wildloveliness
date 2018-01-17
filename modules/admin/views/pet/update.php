<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Pet */

$this->title = Yii::t('forms', 'Update Pet: {nameAttribute}', [
    'nameAttribute' => $pet->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Pets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('forms', 'Update') . ' ' . $pet->name;
?>
<div class="pet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('pet', 'colors', 'titles', 'litters', 'statuses')) ?>

</div>

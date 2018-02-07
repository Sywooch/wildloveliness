<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('adminPages', 'Update: {nameAttribute}', [
    'nameAttribute' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('forms', 'Update') . ' ' . $model->username];
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

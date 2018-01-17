<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Status */

$this->title = Yii::t('adminPages', 'Update {modelClass}: ', [
    'modelClass' => 'Status',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('adminPages', 'Update') . ' ' . $model->title;
?>
<div class="status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

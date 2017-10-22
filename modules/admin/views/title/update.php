<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Title */

$this->title = Yii::t('adminPages', 'Update {modelClass}: ', [
    'modelClass' => 'Title',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Titles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('adminPages', 'Update');
?>
<div class="title-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

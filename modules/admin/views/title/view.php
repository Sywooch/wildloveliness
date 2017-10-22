<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Title */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Titles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('forms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('forms', 'Are you sure you want to delete this title?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'abbr',
            'description',
        ],
    ]) ?>

</div>

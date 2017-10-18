<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Litter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('litter', 'Litters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="litter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('litter', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('litter', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('litter', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'charcode',
            'birthdate',
            'father_id',
            'mother_id',
        ],
    ]) ?>

</div>

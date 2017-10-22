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

            [   // дата рождения
                'label' => Yii::t('litter', 'Birthdate'),
                'value' => date("d.m.Y" ,$model->birthdate),
            ],
            [   // отец
                'label' => Yii::t('litter', 'Father ID'),
                'value' => $model->father->name,
            ],
            [   // мать
                'label' => Yii::t('litter', 'Mother ID'),
                'value' => $model->mother->name,
            ],
        ],
    ]) ?>

</div>

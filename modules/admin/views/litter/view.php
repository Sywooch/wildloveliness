<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Litter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Litters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="litter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('forms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('forms', 'Are you sure you want to delete this litter?'),
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
                'label' => Yii::t('forms', 'Birthdate'),
                'value' => date("d.m.Y" ,$model->birthdate),
            ],
            [   // отец
                'label' => Yii::t('forms', 'Father ID'),
                'value' => $model->father->name,
            ],
            [   // мать
                'label' => Yii::t('forms', 'Mother ID'),
                'value' => $model->mother->name,
            ],
        ],
    ]) ?>

</div>

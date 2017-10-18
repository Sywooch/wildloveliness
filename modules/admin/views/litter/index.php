<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('litter', 'Litters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="litter-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('litter', 'Create Litter'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // CHARCODE
            [
                'attribute' => 'charcode',
                'label' => Yii::t('litter', 'Charcode'),
            ],

            // LITTER BIRTHDATE
            [
                'attribute' => 'birthdate',
                'format' => ['date', 'php:d.m.Y'],
                'label' => Yii::t('litter', 'Date of birth'),
            ],

            // FATHER
            [
                'value' => function ($data) {
                    return $data->father->name;
                },
                'label' => Yii::t('litter', 'Father'),
            ],

            // MOTHER
            [
                'value' => function ($data) {
                    return $data->mother->name;
                },
                'label' => Yii::t('litter', 'Mother'),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

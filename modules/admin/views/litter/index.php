<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('adminPages', 'Litters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="litter-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Create litter'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // CHARCODE
            [
                'attribute' => 'charcode',
                'label' => Yii::t('forms', 'Charcode'),
            ],

            // LITTER BIRTHDATE
            [
                'attribute' => 'birthdate',
                'format' => ['date', 'php:d.m.Y'],
                'label' => Yii::t('forms', 'Birthdate'),
            ],

            // FATHER
            [
                'value' => function ($data) {
                    return $data->father->name;
                },
                'label' => Yii::t('forms', 'Father ID'),
            ],

            // MOTHER
            [
                'value' => function ($data) {
                    return $data->mother->name;
                },
                'label' => Yii::t('forms', 'Mother ID'),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => Yii::t('forms', 'Are you sure you want to delete this litter?'),
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

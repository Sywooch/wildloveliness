<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('adminPages', 'Colors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="color-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Create Color'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'description',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => Yii::t('forms', 'Are you sure you want to delete this color?'),
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

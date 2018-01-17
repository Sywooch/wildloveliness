<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('adminPages', 'Statuses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('adminPages', 'Create Status'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $index) {
                        return Html::a('<span class="glyphicon glyphicon-pencil btn btn-default btn-xs"></span>',
                            $url, [
                                'title' => \Yii::t('yii', 'Update')
                            ]);
                    },
                    'delete' => function ($url, $model, $index) {
                        return Html::a('<span class="glyphicon glyphicon-trash btn btn-default btn-xs"></span>',
                            $url, [
                                'title' => \Yii::t('yii', 'Delete'),
                                'data-confirm' => \Yii::t('forms', 'Are you sure you want to delete this pet?'),
                                'data-method' => 'post',
                                'data-pjax' => '1',
                            ]);
                    }
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

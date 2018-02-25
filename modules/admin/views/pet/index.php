<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use app\assets\JscookiesAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('adminPages', 'Pets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['enablePushState' => false]); ?>

    <p>
        <?= Html::a(Yii::t('adminPages', 'Create Pet'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',

            // PET GENDER
            [
                'value' => function ($data) {
                    $gender = $data->gender == 'm' ? 'Кот' : 'Кошка';
                    return $gender;
                },
                'label' => Yii::t('forms', 'Gender'),
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'gender', // поле в модели, для которого применяется сортировка
                    ['m'=>'Кот', 'f'=>'Кошка'],
                    ['class' => 'form-control', 'prompt' => 'Все']
                )
            ],

            // PET BIRTHDATE RANGE
            [
                'attribute' => 'birthdate',
                'format' => ['date', 'php:d.m.Y'],
                'label' => Yii::t('forms', 'Birthdate'),
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'language' => 'ru-RU',
                    'convertFormat' => true,
                    'type' => DatePicker::TYPE_RANGE,
                    'name' => 'birthMin',
                    'value' => $searchModel->birthMin == null
                        ? date('d.m.Y', \app\modules\admin\models\Pet::find()->min('birthdate'))
                        : $searchModel->birthMin,
                    'name2' => 'birthMax',
                    'value2' => $searchModel->birthMax == null
                        ? date('d.m.Y', \app\modules\admin\models\Pet::find()->max('birthdate'))
                        : $searchModel->birthMax,
                    'separator' => '-',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd.MM.yyyy'
                    ],
                    'pluginEvents' => [
                        "clearDate" => "function(e) { console.log(e) }",
                        "changeDate" => "function(e) { console.log(e)}",
                    ]
                ])
            ],

            // PET STATUS
            [
                'value' => function ($data) {return $data->status->title;},
                'label' => Yii::t('forms', 'Status'),
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status_id', // поле в модели, для которого применяется сортировка
                    ArrayHelper::map(\app\modules\admin\models\Status::find()->asArray()->all(), 'id', 'title'),
                    ['class' => 'form-control', 'prompt' => 'Все']
                )
            ],

            // PET COLOR
            [
                'value' => function ($data) {return $data->color->name;},
                'label' => Yii::t('forms', 'Color'),
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'color_id', // поле в модели, для которого применяется сортировка
                    ArrayHelper::map(\app\modules\admin\models\Color::find()->asArray()->all(), 'id', 'name'),
                    ['class' => 'form-control', 'prompt' => 'Все']
                )

            ],

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


    <?php Pjax::end(); ?>
</div>

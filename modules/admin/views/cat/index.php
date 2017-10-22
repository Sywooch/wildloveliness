<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('adminPages', 'Cats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Create cat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',],

            //'id',
            'name',

            // CAT BIRTHDATE
            [
                'attribute' => 'birthdate',
                'format' => ['date', 'php:d.m.Y'],
                'label' => Yii::t('forms', 'Birthdate'),
            ],

            // CAT TITLE
            [
                'value' => function ($data) {
                    $titleAbbr = $data->title->abbr;
                    $titleFull = $data->title->description;
                    return $titleAbbr ? $titleFull . " ( " . $titleAbbr .")" : $titleFull;
                },
                'label' => Yii::t('forms', 'Title'),
            ],

            // CAT GENDER
            [
                'value' => function ($data) {
                    switch ($data->gender) {
                        case 'm':
                            $gender = 'Кот';
                            break;
                        case 'f':
                            $gender = 'Кошка';
                            break;
                        default:
                            $gender = 'Кастрат';
                            break;
                    }
                    return $gender;
                },
                'label' => Yii::t('forms', 'Gender'),
            ],

            // CAT COLOR
            [
                'value' => function ($data) {
                    return $data->color->name . " ( " . $data->color->description .")"; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'label' => Yii::t('forms', 'Color'),
            ],

            // CAT OWNER
            [
                'value' => function ($data) {
                    return $data->is_owned ? "Wild loveliness" : "Другой";
                },
                'label' => Yii::t('forms', 'Is owned'),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => Yii::t('forms', 'Are you sure you want to delete this cat?'),
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

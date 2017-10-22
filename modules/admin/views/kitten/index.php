<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('adminPages', 'Kittens');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kitten-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Create kitten'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',

            // KITTEN LITTER CHARCODE
            [
                'value' => function ($data) {
                    return $data->litter->charcode  ;
                },
                'label' => Yii::t('forms', 'Litter'),
            ],

            // KITTEN TITLE
            [
                'value' => function ($data) {
                    $titleAbbr = $data->title->abbr;
                    $titleFull = $data->title->description;
                    return $titleAbbr ? $titleFull . " ( " . $titleAbbr .")" : $titleFull;
                },
                'label' => Yii::t('forms', 'Title'),
            ],

            // KITTEN GENDER
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

            // KITTEN COLOR
            [
                'value' => function ($data) {
                    return $data->color->name . " ( " . $data->color->description .")"; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'label' => Yii::t('forms', 'Color'),
            ],

            // KITTEN STATUS
            [
                'value' => function ($data) {
                    return $data->status->title;
                },
                'label' => Yii::t('forms', 'Status'),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => Yii::t('forms', 'Are you sure you want to delete this kitten?'),
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

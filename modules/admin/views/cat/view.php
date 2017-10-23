<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Cat */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Cats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('forms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('forms', 'Are you sure you want to delete this cat?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',

            // Cat birthdate
            [
                'attribute' => 'birthdate',
                'format' => ['date', 'php:d.m.Y'],
                'label' => Yii::t('forms', 'Birthdate'),
            ],

            // Cat title
            [
                'value' => function ($data) {
                    $titleAbbr = $data->title->abbr;
                    $titleFull = $data->title->description;
                    return $titleAbbr ? $titleFull . " ( " . $titleAbbr .")" : $titleFull;
                },
                'label' => Yii::t('forms', 'Title'),
            ],

            // Cat gender
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

            // Cat color
            [
                'value' => function ($data) {
                    return $data->color->name . " ( " . $data->color->description .")"; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'label' => Yii::t('forms', 'Color'),
            ],

            // Cat owner
            [
                'value' => function ($data) {
                    return $data->is_owned ? "Wild loveliness" : Yii::t('cat', 'Other');
                },
                'label' => Yii::t('forms', 'Is owned'),
            ],
        ],
    ]) ?>

</div>

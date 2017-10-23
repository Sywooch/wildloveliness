<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Kitten */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Kittens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kitten-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('forms', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('forms', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('forms', 'Are you sure you want to delete this kitten?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',

            // Kitten litter
            [
                'value' => function ($data) {
                    return $data->litter->charcode;
                },
                'label' => Yii::t('forms', 'Charcode'),
            ],

            // Kitten title
            [
                'value' => function ($data) {
                    $titleAbbr = $data->title->abbr;
                    $titleFull = $data->title->description;
                    return $titleAbbr ? $titleFull . " ( " . $titleAbbr .")" : $titleFull;
                },
                'label' => Yii::t('forms', 'Title'),
            ],

            // Kitten gender
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

            // Kitten color
            [
                'value' => function ($data) {
                    return $data->color->name . " ( " . $data->color->description .")"; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'label' => Yii::t('forms', 'Color'),
            ],

            // Kitten ststus
            [
                'value' => function ($data) {
                    return $data->status->title;
                },
                'label' => Yii::t('forms', 'Title'),
            ],
        ],
    ]) ?>

</div>

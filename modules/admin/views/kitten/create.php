<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Kitten */

$this->title = Yii::t('adminPages', 'Create Kitten');
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Kittens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kitten-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'kitten' => $kitten,
        'colors' => $colors,
        'titles' => $titles,
        'litters' => $litters,
        'statuses' => $statuses
    ]) ?>

</div>

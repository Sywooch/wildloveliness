<?php

use yii\helpers\Html;
use \app\helpers\DevHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Cat */

$this->title = Yii::t('cat', 'Update {modelClass}: ', [
    'modelClass' => 'Cat',
]) . $cat->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cat', 'Cats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cat->name, 'url' => ['view', 'id' => $cat->id]];
$this->params['breadcrumbs'][] = Yii::t('cat', 'Update');
?>
<div class="cat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'cat' => $cat,
        'titles' => $titles,
        'colors' => $colors,
    ]) ?>

</div>
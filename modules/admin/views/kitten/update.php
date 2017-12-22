<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Kitten */

$this->title = Yii::t('adminPages', 'Update {modelClass}: ', [
    'modelClass' => 'Kitten',
]) . $kitten->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Kittens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $kitten->name, 'url' => ['view', 'id' => $kitten->id]];
$this->params['breadcrumbs'][] = Yii::t('adminPages', 'Update');
?>
<div class="kitten-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('kitten', 'colors','titles','litters', 'statuses')) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Cat */

$this->title = Yii::t('adminPages', 'Update {modelClass}: ', [
    'modelClass' => 'Cat',
]) . $cat->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Cats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cat->name, 'url' => ['view', 'id' => $cat->id]];
$this->params['breadcrumbs'][] = Yii::t('adminPages', 'Update');
?>
<div class="cat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('cat', 'colors', 'titles')); ?>

</div>
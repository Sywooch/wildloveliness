<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Color */

$this->title = Yii::t('adminPages', 'Update {modelClass}: ', [
    'modelClass' => 'Color',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Colors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('adminPages', 'Update') . ' ' . $model->name;
?>
<div class="color-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

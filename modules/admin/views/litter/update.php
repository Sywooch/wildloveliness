<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Litter */

$this->title = Yii::t('litter', 'Update {modelClass}: ', [
    'modelClass' => 'Litter',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('litter', 'Litters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('litter', 'Update');
?>
<div class="litter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

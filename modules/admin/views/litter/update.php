<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Litter */

$this->title = Yii::t('litter', 'Update {modelClass}: ', [
    'modelClass' => 'Litter',
]) . $litter->charcode;
$this->params['breadcrumbs'][] = ['label' => Yii::t('litter', 'Litters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $litter->charcode, 'url' => ['view', 'id' => $litter->id]];
$this->params['breadcrumbs'][] = Yii::t('litter', 'Update');
?>
<div class="litter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'litter' => $litter,
        'father' => $father,
        'mother' => $mother
    ]) ?>

</div>

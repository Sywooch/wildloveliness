<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Litter */

$this->title = Yii::t('adminPages', 'Create Litter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('adminPages', 'Litters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="litter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'litter' => $litter,
        'father' => $father,
        'mother' => $mother
    ]) ?>

</div>

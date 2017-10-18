<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Litter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="litter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'charcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->textInput() ?>

    <?= $form->field($model, 'father_id')->textInput() ?>

    <?= $form->field($model, 'mother_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('litter', 'Create') : Yii::t('litter', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Kitten */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kitten-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <?= $form->field($kitten, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <!-- select litter -->
                <?= $form->field($kitten, 'litter_id')->dropdownList($litters,
                    ['prompt'=> Yii::t('forms', 'Select litter')]
                ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <!-- select title -->
                <?= $form->field($kitten, 'title_id')->dropdownList($titles,
                    ['prompt'=> Yii::t('forms', 'Select title')]
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <!-- select gender -->
                <?= $form->field($kitten, 'gender')->dropdownList([
                    m => Yii::t('forms', 'Male cat'),
                    f => Yii::t('forms', 'Female cat'),
                    n => Yii::t('forms', 'Neutered'),
                ],
                    ['prompt'=>Yii::t('forms', 'Select gender')]
                ); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <!-- select color -->
                <?= $form->field($kitten, 'color_id')->dropdownList($colors,
                    ['prompt'=> Yii::t('forms', 'Select color')]
                ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <!-- select status -->
                <?= $form->field($kitten, 'status_id')->dropdownList($statuses,
                    ['prompt'=> Yii::t('forms', 'Select status')]
                ); ?>
            </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton($kitten->isNewRecord ? Yii::t('forms', 'Create') : Yii::t('forms', 'Save'), ['class' => $kitten->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

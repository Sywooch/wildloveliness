<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DatepickerAsset;

DatepickerAsset::register($this);
?>

<div class="cat-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <?= $form->field($cat, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6">
                <?= $form->field($cat, 'birthdate')->textInput(['value' => $cat->birthdate ? date("d.m.Y" ,$cat->birthdate) : date("d.m.Y" ,time())]) ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select color -->
                <?= $form->field($cat, 'color_id')->dropdownList($colors,
                    ['prompt'=> Yii::t('forms', 'Select color')]
                ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select title -->
                <?= $form->field($cat, 'title_id')->dropdownList($titles,
                    ['prompt'=> Yii::t('forms', 'Select title')]
                ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select gender -->
                <?= $form->field($cat, 'gender')->dropdownList([
                    m => Yii::t('forms', 'Male cat'),
                    f => Yii::t('forms', 'Female cat'),
                    n => Yii::t('forms', 'Neutered'),
                ],
                    ['prompt'=>Yii::t('forms', 'Select gender')]
                ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select owner -->
                <?= $form->field($cat, 'is_owned')->dropdownList([
                    0 => Yii::t('cat', 'Other'),
                    1 => Yii::t('cat', 'Wild loveliness')
                ],
                    ['prompt'=>Yii::t('forms', 'Select owner')]
                ); ?>
            </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton($cat->isNewRecord ? Yii::t('forms', 'Create') : Yii::t('forms', 'Save'), ['class' => $cat->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

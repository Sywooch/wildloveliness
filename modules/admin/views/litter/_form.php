<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DatepickerAsset;

DatepickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Litter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="litter-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?= $form->field($litter, 'charcode')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">







            <label class="control-label" for="litter-father_id">Дата рождения</label>
            <div class="input-group date">
                <input type="text" class="form-control"><span class="input-group-addon date-input"><i class="glyphicon glyphicon-th"></i></span>
            </div>
            <?= $form->field($litter, 'birthdate')->hiddenInput()->label(false) ?>




        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <!-- select father -->
            <?= $form->field($litter, 'father_id')->dropdownList($father,
                ['prompt'=> Yii::t('litter', 'Select father')]
            ); ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <!-- select mother -->
            <?= $form->field($litter, 'mother_id')->dropdownList($mother,
                ['prompt'=> Yii::t('litter', 'Select mother')]
            ); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($litter->isNewRecord ? Yii::t('litter', 'Create') : Yii::t('litter', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

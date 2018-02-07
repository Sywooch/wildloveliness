<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$userRoleName = reset(Yii::$app->authManager->getAssignments($model->id))->roleName;

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-3">
                <?= $form->field($model, 'username')->textInput(['value' => $model->username]) ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <?= $form->field($model, 'email')->textInput(['value' => $model->email]) ?>
            </div>


            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select user role -->
                <?= $form->field($model, 'role')->dropdownList(
                    ArrayHelper::map(ArrayHelper::toArray(Yii::$app->authManager->getRoles()), 'name', 'description'),
                    [
                        'prompt'=>Yii::t('forms', 'Select role'),
                        'options' => [$userRoleName => ['selected' => true]]
                    ]
                ); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select user status -->
                <?= $form->field($model, 'status')->dropdownList(
                    [0 => 'Удален', 10 => 'Активен'],
                    ['prompt'=>Yii::t('forms', 'Select status'),]
                ); ?>
            </div>



        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('forms', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

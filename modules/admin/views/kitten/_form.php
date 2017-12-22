<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use app\modules\filemanager\assets\FilemanagerAsset;

$filemngrAsset = FilemanagerAsset::register($this);
?>

<div class="kitten-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <?= $form->field($kitten, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <!-- select status -->
                <?= $form->field($kitten, 'status_id')->dropdownList($statuses,
                    ['prompt'=> Yii::t('forms', 'Select status')]
                ); ?>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select litter -->
                <?= $form->field($kitten, 'litter_id')->dropdownList($litters,
                    ['prompt'=> Yii::t('forms', 'Select litter')]
                ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select gender -->
                <?= $form->field($kitten, 'gender')->dropdownList([
                    m => Yii::t('forms', 'Male cat'),
                    f => Yii::t('forms', 'Female cat'),
                    n => Yii::t('forms', 'Neutered'),
                ],
                    ['prompt'=>Yii::t('forms', 'Select gender')]
                ); ?>
            </div>

            <div class="clearfix hidden-md hidden-lg"></div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select color -->
                <?= $form->field($kitten, 'color_id')->dropdownList($colors,
                    ['prompt'=> Yii::t('forms', 'Select color')]
                ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <!-- select title -->
                <?= $form->field($kitten, 'title_id')->dropdownList($titles,
                    ['prompt'=> Yii::t('forms', 'Select title')]
                ); ?>
            </div>

            <div class="imgsList col-xs-12">
                <div class="row">
                    <?php if(Json::decode($kitten->imgs)):?>
                        <?php foreach(Json::decode($kitten->imgs) as $key=>$img):?>
                            <div id="imgItem<?=$key?>" class="col-xs-6 col-sm-4 col-md-2">
                                <a class="thumbnail" href="#">
                                    <div class="deleteImgBtn">
                                        <?=Html::img($filemngrAsset->baseUrl.'/imgs/delete.svg', [
                                            'data-imgItem'=>'imgItem'.$key,
                                            'title'=>'Удалить...',
                                            'data-toggle'=>'tooltip',
                                            'data-placement'=>'top',
                                        ]);?>
                                    </div>
                                    <img src="<?=$img?>" />
                                    <input name="img<?=$key?>" value="<?=$img?>">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="col-xs-6 col-sm-4 col-md-2">
                        <a href="#" data-target="#roxyMainModal" data-toggle="modal" class="thumbnail col-xs-4 col-md-2">
                            <?= Html::img('@web/imgs/camera.svg', ['alt' => $cat->name, 'class' => emptyImg]) ?>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    <div class="form-group">
        <?= Html::submitButton($kitten->isNewRecord ? Yii::t('forms', 'Create') : Yii::t('forms', 'Save'), ['class' => $kitten->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

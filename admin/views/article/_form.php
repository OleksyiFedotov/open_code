<?php

use app\models\Article;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-3">
                <?=$form->field($model, 'title_en')->textInput(['maxlength' => true,]) ?>
                <?=$form->field($model, 'title_uk')->textInput(['maxlength' => true,]) ?>
            </div>
            <div class="col-md-3">
                <?=$form->field($model, 'keywords')->textInput(['maxlength' => true,]) ?>
            </div>
            <div class="col-md-3">
                <?=$form->field($model, 'status')->checkbox() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">

                <?=$form->field($model, 'alt_en')->textInput(['maxlength' => true,]) ?>
                <?=$form->field($model, 'alt_uk')->textInput(['maxlength' => true,]) ?>
            </div>
            <div class="col-md-3">
                <?= $model->meta = 'index, follow'?>
                <?= $form->field($model, 'meta')->radioList(
                    ['index, follow' =>'index, follow', 'index, nofollow' => 'index, nofollow']
                ) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <?= $form->field($model, 'content_en')->widget(\yii\redactor\widgets\Redactor::class) ?>
                <?= $form->field($model, 'content_uk')->widget(\yii\redactor\widgets\Redactor::class) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>

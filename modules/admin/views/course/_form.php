<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin([
        'id' => 'course-form',
        'action' => '../create-course/',
        'method'=>'post',
        'enableAjaxValidation' => false,
    ]); ?>
    <p id="output"></p>
    <?= $form->field($model, 'course_name')->textInput(['maxlength' => true])->label('Название курса') ?>

    <?= $form->field($model, 'course_author')->textInput(['maxlength' => true])->label('Автор') ?>

    <?= $form->field($model, 'course_img_url')->textInput()->label('Картнка') ?>
    <?= $form->field($model, 'course_video_url')->textInput()->label('Ссылка на Первый Урок') ?>
    <?= $form->field($model, 'course_description')->textarea()->label('Описание') ?>
    <?= $form->field($model, 'course_price')->textInput()->label('Цена') ?>
    <?= $form->field($model, 'course_preview')->textInput()->label('Ссылка на video preview') ?>

    <?= $form->field($model, 'course_isFree')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

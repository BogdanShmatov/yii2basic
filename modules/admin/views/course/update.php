<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = 'Update Course: ' . $course['course_name'];
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $course['course_name'], 'url' => ['view', 'id' => $course['id']]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <p id="output"></p>
    <?= $form->field($model, 'course_name')->textInput(['maxlength' => true, 'value'=> $course['course_name']])->label('Название курса') ?>

    <?= $form->field($model, 'course_author')->textInput(['maxlength' => true, 'value'=> $course['course_author']])->label('Автор') ?>

    <?= $form->field($model, 'course_img_url')->textInput(['value'=> $course['course_img_url']])->label('Картнка') ?>
    <?= $form->field($model, 'course_video_url')->textInput(['value'=> $course['course_video_url']])->label('Ссылка на Первый Урок') ?>
    <?= $form->field($model, 'course_description')->textarea(['value'=> $course['course_description']])->label('Описание') ?>
    <?= $form->field($model, 'course_price')->textInput(['value'=> $course['course_price']])->label('Цена') ?>
    <?= $form->field($model, 'course_preview')->textInput(['value'=> $course['course_preview']])->label('Ссылка на video preview') ?>

    <?= $form->field($model, 'course_isFree')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

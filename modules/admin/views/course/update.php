<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
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

    <?php $form = ActiveForm::begin([
            'id' => 'course-form',
]); ?>
    <p id="output"></p>
    <?= $form->field($model, 'course_name')->textInput(['maxlength' => true, 'value'=> $course['course_name']])->label('Название курса') ?>

    <?= $form->field($model, 'course_author')->textInput(['maxlength' => true, 'value'=> $course['course_author']])->label('Автор') ?>
    <?php $items = ArrayHelper::map($categories,'id','cat_name');

    $params = [
        'prompt' => 'Выберите категорию...'
    ];
    ?>
    <?= $form->field($model, 'cat_id')->dropDownList($items,$params)->label('Категория курса')  ?>
    <?= $form->field($model, 'course_img_url')->textInput(['value'=> $course['course_img_url']])->label('Картнка') ?>
    <?= $form->field($model, 'course_video_url')->textInput(['value'=> $course['course_video_url']])->label('Ссылка на Первый Урок') ?>
    <?= $form->field($model, 'course_description')->textarea(['value'=> $course['course_description']])->label('Описание') ?>
    <?= $form->field($model, 'course_price')->textInput(['value'=> $course['course_price']])->label('Цена KZT') ?>
    <?= $form->field($model, 'course_preview')->textInput(['value'=> $course['course_preview']])->label('Ссылка на video preview') ?>

    <?= $form->field($model, 'course_isFree')->checkbox() ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-book"></i> Добавление уроков</h4></div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 200, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsLessons[0],
                    'formId' => 'course-form',
                    'formFields' => [
                        'lesson_name',
                        'lesson_url',
                    ],
                ]); ?>

                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelsLessons as $i => $modelLesson):?>
                    <?php foreach ($lessons as $lesson): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Уроки</h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($modelLesson, "[{$i}]lesson_name")->textInput(['maxlength' => true, 'value'=> $lesson['lesson_name']]) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($modelLesson, "[{$i}]lesson_url")->textInput(['maxlength' => true, 'value'=>  $lesson['lesson_url']]) ?>
                                    </div>
                                </div><!-- .row -->

                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

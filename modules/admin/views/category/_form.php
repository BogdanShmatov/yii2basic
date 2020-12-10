<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="course-form">

    <?php $form = ActiveForm::begin([
        'id' => 'category-form',
        'action' => '../create/',
    ]); ?>
    <p id="output"></p>

    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => true])->label('Название Категории') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

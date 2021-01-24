<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-section">
    <div class="container">

        <div class="row" style="padding: 50px">
            <?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <?= $form->field($model, 'last_name')->textInput(['autofocus' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="submit" value="Сохранить" class="btn btn-primary btn-lg px-5">
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">

                        <img src="../../images/profile.jpg" alt="" height="90%" width="90%">
                    </div>

        </div>

    </div>
</div>
    </div>
</div>

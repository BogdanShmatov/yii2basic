<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('../images/bg_1.jpg')">
    <div class="container">
        <div class="row align-items-end justify-content-center text-center">
            <div class="col-lg-7">
                <h2 class="mb-0"><?= $this->title ?></h2>
                <p>Please fill out your email. A link to reset password will be sent there</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-lg px-5', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
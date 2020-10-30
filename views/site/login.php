<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('../images/bg_1.jpg')">
    <div class="container">
        <div class="row align-items-end justify-content-center text-center">
            <div class="col-lg-7">
                <h2 class="mb-0"><?= $this->title ?></h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12 form-group">
                    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                    <div class="col-md-12 form-group">
                        If you forgot your password you can <?= Html::a('reset it', ['request-password-reset']) ?>.
                        <br>
                        Need new verification email? <?= Html::a('Resend', ['resend-verification-email']) ?>
                    </div>

                    <div class="col-md-12 form-group">
                        <?= Html::submitButton('Log In', ['class' => 'btn btn-primary btn-lg px-5', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

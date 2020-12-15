<?php

use app\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
$user = User::findOne(Yii::$app->user->getId());
?>

<div class="site-section">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="course-1-item">
                    <img src="https://seiv.io/wp-content/uploads/sberbank-classic-debitcard-2.png" alt="Image" style="height: 100px;" class="img-fluid center">
                    <div class="line" style="background-image: linear-gradient(to right, #9be3aa, #91e3a8, #85e3a6, #79e2a5, #6ae2a4, #62e2a9, #5ae2af, #52e2b4, #56e2c0, #5ee2ca, #69e1d2, #76e0d9);"><h3>Еще пару шагов!</h3>   </div>
                    <?php $form = ActiveForm::begin(['id' => 'card-form',
                        'options' => [
                            'class' => 'card-form',
                        ],
                    ]); ?>
                    <div class="course-1-content pb-4">
                        <h2>Введите данные карты:</h2>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <?= $form->field($model, 'sum')
                                    ->textInput(['autofocus' => true])
                                    ->label('Сколько закинуть') ?>
                            </div>
                            <div class="col-md-12 form-group">
                                <?= $form->field($model, 'cardNumber')
                                    ->textInput(['maxlength' => 16, 'placeholder'=>'**** **** **** ****','autofocus' => true])
                                    ->label('Номер карты') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex ">
                                <div class="col-2">
                                    <?= $form->field($model, 'expMonth')
                                        ->textInput(['maxlength' => 2, 'placeholder'=>'**','autofocus' => true])
                                        ->label('MM') ?>
                                </div>
                                <span style="font-size: 30px;padding: 0 5px 0 0;color: rgb(78, 73, 73)">/</span>
                                <div class="col-2">
                                    <?= $form->field($model, 'expYear')
                                        ->textInput(['maxlength' => 2, 'placeholder'=>'**','autofocus' => true])
                                        ->label('YY') ?>
                                </div>
                                <div class="col-2">
                                    <?= $form->field($model, 'cvc')
                                        ->passwordInput(['maxlength' => 3, 'placeholder'=>'***','autofocus' => true])
                                        ->label('CVC') ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <?= $form->field($model, 'cardName')
                                    ->textInput(['placeholder'=>'BOGDAN SHMATOV','autofocus' => true])->label('') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?= Html::submitButton('Пополнить', ['class' => 'btn btn-primary btn-lg px-5', 'name' => 'pay-button']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-1-item " style="text-align: left">
                    <div class="course-1-content pb-4" style="text-align: left">
                        <h2>Сведения о балансе:</h2>
                        <div class="row">
                            <div class="col-6"><p>На счету:</p></div>
                            <div class="col-6"><p>$<?php echo $user->balance ?></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

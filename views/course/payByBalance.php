<?php


use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>

<div class="site-section">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="course-1-item">
                    <img src="https://seiv.io/wp-content/uploads/sberbank-classic-debitcard-2.png" alt="Image" style="height: 100px;" class="img-fluid center">
                    <div class="line" style="background-image: linear-gradient(to right, #9be3aa, #91e3a8, #85e3a6, #79e2a5, #6ae2a4, #62e2a9, #5ae2af, #52e2b4, #56e2c0, #5ee2ca, #69e1d2, #76e0d9);"><h3>Еще пару шагов! </h3>   </div>
                    <div class="course-1-content pb-4 " style="text-align: left">
                        <div class="row">
                            <div class="col-6"><p>Доступная сумма на вашем счету:</p></div>
                            <div class="col-6"><p>$<?php echo $user->balance ?></p></div>
                            <div class="col-6"><p>Сумма списания</p></div>
                            <div class="col-6"><p>$<?php echo $course['course_price']; ?></p></div>
                            <div class="col-6"><p>Информация о пользователе</p></div>
                            <div class="col-6"><p><?php echo $user->name.' '.$user->last_name ?></p></div>
                        </div>

                        <?php $form = ActiveForm::begin(['id' => 'balance-form',
                            'options' => [
                                'class' => 'balance-form',
                            ],
                        ]); ?>

                        <div class="row">
                            <?= $form->field($model, 'message')
                                ->checkbox()->hiddenInput()->label('') ?>
                            <div class="col-12">
                                <a href="<?= Url::toRoute(['get-courses']);?>" class="btn btn-secondary btn-lg px-5">Отмена </a>
                                <?php if ($user->balance < $course['course_price']) { ?>
                                    <a href="<?= Url::toRoute(['profile/view-balance']);?>" class="btn btn-secondary btn-lg px-5">Пополнить баланс</a>
                                <?php  } else {?>
                                <?= Html::submitButton('Оплатить', ['class' => 'btn btn-primary btn-lg px-5', 'name' => 'pay-button']) ?>
                            <?php } ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-1-item" style="text-align: left">
                    <div class="course-1-content pb-4" style="text-align: left">
                        <h2>Сведения о покупке:</h2>
                        <div class="row">
                            <div class="col-6"><p>Итоговая цена</p></div>
                            <div class="col-6"><p>$<?php echo $course['course_price']?></p></div>
                            <div class="col-6"><p>Курс</p></div>
                            <div class="col-6"><p><?php echo $course['course_name']?></p></div>
                            <div class="col-6"><p>Автор курса</p></div>
                            <div class="col-6"><p><?php echo $course['course_author']?></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


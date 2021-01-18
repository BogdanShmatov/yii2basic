<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="course-1-item">
                    <figure class="thumnail">
                        <div class="category"><h3>Расскажите пару мелочей о себе!</h3></div>
                    </figure>
                    <div class="course-1-content pb-4">
                        <?php $form = ActiveForm::begin(['id' => 'pesonal-info-form']) ?>
                        <div class="row">
                            <div class="row">
                                <div class="col-12">
                                    <?= $form->field($personalInfo, 'name')->textInput(['autofocus' => true])->label('Имя') ?>

                                </div>

                                <div class="col-12">
                                    <?= $form->field($personalInfo, 'last_name')->label('Фамилия') ?>

                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?= Html::submitButton('Дальше', ['class' => 'btn btn-primary btn-lg px-5', 'name' => 'signup-button']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
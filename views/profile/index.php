<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="site-section">
    <div class="container">
        <div class="row">
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="course-1-item" style="text-align: left">
                        <div class="course-1-content pb-4" style="text-align: left">
                            <h2>Баланс:</h2>
                            <div class="row">
                                <div class="col-12"> <p><?php echo $user->balance?>KZT</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-lg-4 col-md-4 mb-4">
                <div class="course-1-item" style="text-align: left">
                    <div class="course-1-content pb-4" style="text-align: left">
                        <h2>Ваш логин:</h2>
                        <div class="row">
                            <div class="col-12"> <p><?php echo $user->username ?>
                                </p></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 mb-4">
                <div class="course-1-item" style="text-align: left">
                    <div class="course-1-content pb-4" style="text-align: left">
                        <h2>Имя в профиле:</h2>
                        <div class="row">
                            <div class="col-12"> <p><?php echo $user->name.' '.$user->last_name ?>
                                </p></div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        <?php if (Yii::$app->user->can('adminAccess')) { ?>
        <div class="text-center">
            <h1>Мои заметки: (<?php echo count($model); ?>)</h1>

        </div>
        <div class="row">
            <?php foreach ($model as $post): ?>
                <div class="col-lg-12 col-md-6 mb-4">
                    <div class="course-1-item" style="text-align: left">
                        <div class="course-1-content pb-4" style="text-align: left">
                            <h2><?php echo $post->title ?></h2>
                            <div class="row">
                                <div class="col-12"> <p><?php echo $post->description ?>
                                    </p></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; }?></div>

    </div>
</div>
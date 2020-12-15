<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="site-section">
    <?php Pjax::begin([
        'id' => 'pjax-container',
        'enablePushState' => false,
        'enableReplaceState' => false,
    ]) ?>
    <div class="container">


        <div class="row">

            <div class="col-lg-3">
                <div class="course-1-item-my">

                    <div class="category border-bottom category-hover"><h3><a style="color: white" href="/profile/edit-profile/">Мои данные</a></h3></div>
                    <div class="category border-bottom category-hover"><h3><a style="color: #ffffff" href="#">Баланс</a></h3></div>
                    <div class="category border-bottom category-hover"><h3><a style="color: white" href="#">Карты</a></h3></div>
                    <div class="category border-bottom category-hover"><h3><a style="color: white" href="#">#</a></h3></div>
                    <div class="category border-bottom category-hover"><h3><a style="color: white" href="#">#</a></h3></div>
                    <div class="category border-bottom category-hover"><h3><a style="color: white" href="#">#</a></h3></div>
                    <div class="category border-bottom category-hover"><h3><a style="color: white" href="#">#</a></h3></div>
                <?= Html::a('Редактировать данные', ['profile/edit-profile']) ?>


                </div>
            </div>


        </div>
      <div class="row" id="pjax-container">

      </div>


    </div>

    <?php Pjax::end() ?>

</div>

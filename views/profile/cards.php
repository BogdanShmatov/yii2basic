<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="site-section">
    <div class="container">
        <?php if ($model) { ?>
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-6 mb-5">
                    <h1>Ваши карты! :)</h1>
                </div>
            </div>
        <div class="row">
        <?php foreach ($model as $card): ?>
        <div class="col-lg-4 col-md-6 mb-4">
    <div class="course-1-item" style="text-align: left">
        <div class="course-1-content pb-4" style="text-align: left">
            <h2>Карта</h2>
            <div class="row">
                <div class="col-6"><p>************<?php echo $card['card_number'] ?></p></div>
                <div class="col-6"> <p><a href="<?= Url::toRoute(['profile/delete-card', 'id' => $card['id']]);?>">Удалить</a>
                    </p></div>
            </div>
        </div>
    </div>
</div>

        <?php endforeach;  ?> </div><?php } else { ?>
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-6 mb-5">
                    <h1>Нет добавленных карт! ;(</h1>
                    <a href="<?= Url::toRoute(['course/get-courses']);?>" class="btn btn-primary px-4">В магазин</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


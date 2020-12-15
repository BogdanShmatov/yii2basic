<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="site-section">
    <div class="container">
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
        <?php endforeach; ?></div>
    </div>
</div>
<?php

use yii\helpers\Url;
?>

<div class="site-section">
    <div class="container">
       <?php if (!$orders) { ?>
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-4 mb-5">
                <h1 class="section-title-underline mb-5">
                    <span>Hi, <?php echo Yii::$app->user->identity->name ?></span>
                </h1>
                <h4>Вы еще не покупали курсы ;)</h4>
                <a href="<?= Url::toRoute(['course/get-courses']);?>" class="btn btn-primary px-4">Купить</a>
            </div>
        </div>
        <?php } else { ?>
        <div class="row">
            <div class="col-lg-12 mb-5">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Курс</th>
                        <th scope="col">Дата покупки</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Скачать чек</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0, $size = (count($orders)); $i < $size; $i++ ) { ?>
                    <tr>
                        <th scope="row"><?php echo $i + 1 ?></th>
                        <td><?php echo $coursesName[$i]['course_name'] ?></td>
                        <td><?php echo $orders[$i]['created_at'] ?></td>
                        <td>$<?php echo $orders[$i]['order_total_price'] ?></td>
                        <td><a href="#">mdo</a>@</td>
                    </tr>
                    <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

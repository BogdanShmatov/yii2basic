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
                <h1 class="text-center">Купленные курсы</h1>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Курс</th>
                        <th scope="col">Дата покупки</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Invoice</th>
                        <th scope="col">Operation</th>
                        <th scope="col">Чек</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0, $size = (count($orders)); $i < $size; $i++ ) { ?>
                    <tr>
                        <th scope="row"><?php echo $i + 1 ?></th>
                        <td id="#course" data-name="name course"><?php echo $coursesName[$i]['course_name'] ?></td>
                        <td id="#date"><?php echo $orders[$i]['created_at'] ?></td>
                        <td id="#price"><?php echo $orders[$i]['order_total_price'] ?>KZT</td>
                        <td id="#invoice"><?php echo $orders[$i]['invoice_id'] ?></td>
                        <td id="#operation"><?php echo $orders[$i]['operation_id'] ?></td>
                        <td>
                            <a class="view-purch" href="" data-toggle="modal" data-target="#exampleModal">Посмотреть</a>
                            <a href="https://www.test.wooppay.com/money/receipt/operationID/<?php echo $orders[$i]['operation_id'] ?>/print/pdf">↓</a>
                        </td>
                    </tr>
                    <?php }} ?>
                    </tbody>
                </table>


            </div>
        </div>

        <?php if (!$balanceEnroll) { ?>
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-4 mb-5">
                    <h1 class="section-title-underline mb-5">
                        <span>Wooopss, <?php echo Yii::$app->user->identity->name ?></span>
                    </h1>
                    <h4>Вы еще не пополняли баланс;)</h4>
                    <a href="<?= Url::toRoute(['profile/view-balance']);?>" class="btn btn-primary px-4">Пополнить</a>
                </div>
            </div>
        <?php } else { ?>
        <div class="row">
            <div class="col-lg-12 mb-5">
                <h1 class="text-center">История пополнений</h1>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Дата покупки</th>
                        <th scope="col">Сумма</th>
                        <th scope="col">Invoice</th>
                        <th scope="col">Operation</th>
                        <th scope="col">Чек</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0, $size = (count($balanceEnroll)); $i < $size; $i++ ) { ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <td id="#course" data-name="name course">Пополнение баланса</td>
                            <td id="#date"><?php echo $balanceEnroll[$i]['created_at'] ?></td>
                            <td id="#price"><?php echo $balanceEnroll[$i]['sum'] ?>KZT</td>
                            <td id="#invoice"><?php echo $balanceEnroll[$i]['invoice_id'] ?></td>
                            <td id="#operation"><?php echo $balanceEnroll[$i]['operation_id'] ?></td>
                            <td>
                                <a class="view-purch" href="" data-toggle="modal" data-target="#exampleModal">Посмотреть</a>
                                <a href="https://www.test.wooppay.com/money/receipt/operationID/<?php echo $balanceEnroll[$i]['operation_id'] ?>/print/pdf">↓</a>
                            </td>
                        </tr>
                    <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ваш чек    <?php echo Yii::$app->user->identity->name.' '.Yii::$app->user->identity->last_name ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6"><p>Итоговая цена</p></div>
                            <div class="col-6"> <p class="course-price"></p> </div>
                            <div class="col-6"><p>Курс</p></div>
                            <div class="col-6"><p class="course-name"></p></div>
                            <img src="/images/academic.png" alt="acd" style="width: 100px;position: absolute;right: 40px;bottom: -15px;">
                            <div class="col-6"><p>Дата покупки</p></div>
                            <div class="col-6" style="z-index: 1;"><p class="course-date"></p></div>
                            <div class="col-6"><p>Аккаунт:</p></div>
                            <div class="col-6" style="z-index: 1;"><p><?php echo Yii::$app->user->identity->username ?></p></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--  End Modal  -->
    </div>
</div>

<?php
$js = <<< JS
$(".view-purch").on("click", function(event, elem){
    let obj = [];
    $(this).closest("tr").find("td").each(function(idx, itm){
        obj[idx] = itm.textContent;
    });
    $('.course-price').text(obj[2]);
        $('.course-name').text(obj[0]);
        $('.course-date').text(obj[1]);
});
JS;
$this->registerJs( $js, $position = yii\web\View::POS_READY );
?>

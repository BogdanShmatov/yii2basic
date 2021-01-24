<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<div class="site-section">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8 col-md-6 mb-4">
<!--                    <iframe width="100%" height="700px" style="border: none;" src=" --><?php //// $invoice['operation_url'] ?><!--"></iframe>-->
                <h4>Для совершения безопасной транзакции вы будете перенаправлены на сайт партнера ;) </h4>
                <h6>Если этого не произошло кликните <a href="<?= $frame_url?>">вот тут</a> !</h6>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-1-item " style="text-align: left">
                    <div class="course-1-content pb-4" style="text-align: left">
                        <h2>Сведения о покупке:</h2>
                        <div class="row">
                            <div class="col-6"><p>Итоговая цена</p></div>
                            <div class="col-6"><p><?php echo $course['course_price']?>KZT</p></div>
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

<?php
$js = <<< JS
let frameUrl = '$frame_url'
    setTimeout(function(){
        window.location.replace(frameUrl);
    }, 2000)
JS;
$this->registerJs( $js, $position = yii\web\View::POS_READY );
?>
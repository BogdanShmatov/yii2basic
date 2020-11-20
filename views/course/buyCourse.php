<?php
use yii\helpers\Url;
?>

<div class="site-section">
        <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-6 col-md-6 mb-4">
                <div class="course-1-item">
                    <figure class="thumnail">
                              <img src="<?php echo $course['course_img_url']?>" alt="Image" class="img-fluid">
                    <div class="category"><h3>Осталось совсем немного!</h3><div class="price">$<?php echo $course['course_price']?></div></div>
                    </figure>
                    <div class="course-1-content pb-4">
                      <h2>Сведения о покупке:</h2>
                        <div class="row">
                                <div class="col-6"><p>Итоговая цена</p></div>
                                <div class="col-6"> <p>$<?php echo $course['course_price']?></p> </div>
                                <div class="col-6"><p>Курс</p></div>
                                <div class="col-6"><p><?php echo $course['course_name']?></p></div>
                                <div class="col-6"><p>Автор курса</p></div>
                                <div class="col-6"><p><?php echo $course['course_author']?></p></div>
                        </div>
                    <p class="desc mb-4">Как удобно оплатить? Смелей выбирай, обучение ждет?!!</p>
                    <div class="row">
                      <div class="col-6">
                          <a href="<?= Url::toRoute(['pay-by-card', 'id'=>$course['id']]);?>"  class="btn btn-primary btn-lg px-5">Картой </a>
                      </div>
                      <div class="col-6">
                          <a href="<?= Url::toRoute(['pay-by-balance', 'id'=>$course['id'], 'user_id'=>Yii::$app->user->id]);?>" class="btn btn-primary btn-lg px-5">С баланса </a>
                    </div>
                  </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
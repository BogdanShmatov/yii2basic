<?php

use app\common\helpers\ButtonHelper;
use yii\helpers\Url;

$this->title = 'Courses';

?>
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('/images/bg_1.jpg')">
        <div class="container">
          <div class="row align-items-end">
            <div class="col-lg-7">
              <h2 class="mb-0"><?= $this->title ?></h2>
            </div>
          </div>
        </div>
      </div>
    <div class="site-section">
        <div class="container">
            <div class="row">
                <?php foreach($courses as $course):?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="course-1-item" >
                            <figure class="thumnail">
                                <?php
                                if (in_array($course['id'], $courseUser)) {?>

                                <a href="<?= Url::toRoute(['continue-course', 'id'=>$course['id']]);?>">

                                <?php } else {?>

                                    <a href="<?= Url::toRoute(['view', 'id'=>$course['id']]);?>">

                                        <?php }?>

                                        <img src="<?php echo $course['course_img_url']?>" alt="Image" class="img-fluid"></a>
                                    <div class="price">$
                                        <?php if($course['course_isFree']){ ?> Free <?php } else echo $course['course_price']?></div>
                                    <div class="category">

                                        <h3>  <?php if (in_array($course['id'], $courseUser)) {?>
                                            <a href="<?= Url::toRoute(['continue-course', 'id'=>$course['id']]);?>">

                                                <?php } else {?>
                                                <a href="<?= Url::toRoute(['view', 'id'=>$course['id']]);?>">

                                                    <?php }?>
                                                    <?php echo $course['course_name'];?></a></h3>
                                    </div>
                            </figure>
                            <div class="course-1-content pb-4" >
                                <?php if (in_array($course['id'], $courseUser)) {?>

                                <a href="<?= Url::toRoute(['continue-course', 'id'=>$course['id']]);?>">

                                    <?php } else {?>
                                    <a href="<?= Url::toRoute(['view', 'id'=>$course['id']]);?>">

                                        <?php }?>

                                        <h2><?php echo $course['course_description']?></h2></a>

                                    <div class="rating text-center mb-3">
                                        <span class="icon-star2 text-warning"></span>
                                        <span class="icon-star2 text-warning"></span>
                                        <span class="icon-star2 text-warning"></span>
                                        <span class="icon-star2 text-warning"></span>
                                        <span class="icon-star2 text-warning"></span>
                                    </div>
                                    <p><?php echo $course['cat']['cat_name']?></p>
                                    <p class="desc mb-4" ><?php echo $course['course_author']?></p>

                                    <?php
                                    //хелпер
                                    if (in_array($course['id'], $courseUser)) {

                                        echo ButtonHelper::createButton(Url::toRoute([
                                            'continue-course',
                                            'id' => $course['id']]),
                                            'Продолжить');

                                    } else if ($course['course_isFree']) {

                                        echo ButtonHelper::createButton(Url::toRoute([
                                            'buy-course',
                                            'id' => $course['id']]),
                                            'В коллекцию');

                                    } else {

                                        echo ButtonHelper::createButton(Url::toRoute([
                                            'buy-course',
                                            'id' => $course['id']]),
                                            'Купить');
                                        } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

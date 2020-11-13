<?php

use yii\helpers\Url;

$this->title = 'Courses';


?>
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('../images/bg_1.jpg')">
        <div class="container">
          <div class="row align-items-end">
            <div class="col-lg-7">
              <h2 class="mb-0"><?= $this->title ?></h2>

              <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
            </div>
          </div>
        </div>
      </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <?php foreach($courses as $course): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="course-1-item" >
                        <figure class="thumnail">
                        <a href="<?= Url::toRoute(['view', 'id'=>$course->id]);?>"><img src="<?php echo $course->course_img_url?>" alt="Image" class="img-fluid"></a>
                        <div class="price">$<?php
                            if($course->course_isFree){ ?>
                                Free
                            <?php } else
                                echo $course->course_price?></div>
                        <div class="category" style="overflow: hidden; width: 100%; height: 49px"><h3 ><a style="color: #FFFFFF" href="<?= Url::toRoute(['view', 'id'=>$course->id]);?>"><?php echo $course->course_name?></a></h3></div>
                        </figure>
                        <div class="course-1-content pb-4" >
                       <a href="<?= Url::toRoute(['view', 'id'=>$course->id]);?>" > <h2 style="overflow: hidden; height: 70px;"><?php echo $course->course_description?></h2></a>
                        <div class="rating text-center mb-3">
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                        </div>
                            <p style="overflow: hidden; height: 30px;"><?php echo $course->cat->cat_name?></p>
                        <p class="desc mb-4" ><?php echo $course->course_author?></p>
                            <?php
                            if($course->course_isFree){

                            ?>
                            <p><a href="<?= Url::toRoute(['buy-course', 'id'=>$course->id]);?>" class="btn btn-primary rounded-0 px-4">В коллекцию</a></p>

                            <?php  }else{
                            ?>
                        <p><a href="<?= Url::toRoute(['buy-course', 'id'=>$course->id]);?>" class="btn btn-primary rounded-0 px-4">Купить</a></p>
                            <?php  }
                            ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

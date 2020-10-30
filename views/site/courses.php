<?php

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
                    <div class="course-1-item">
                        <figure class="thumnail">
                        <a href="course-single.html"><img src="../images/course_1.jpg" alt="Image" class="img-fluid"></a>
                        <div class="price">$<?php
                            if($course->course_isFree){ ?>
                                Free
                            <?php } else
                                echo $course->course_price?></div>
                        <div class="category"><h3><?php echo $course->course_name?></h3></div>
                        </figure>
                        <div class="course-1-content pb-4">
                        <h2><?php echo $course->course_description?></h2>
                        <div class="rating text-center mb-3">
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                        </div>
                            <p><?php echo $course->cat->cat_name?></p>
                        <p class="desc mb-4"><?php echo $course->course_author?></p>
                            <?php
                            if($course->course_isFree){

                            ?>
                            <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">В коллекцию</a></p>

                            <?php  }else{
                            ?>
                        <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">Купить</a></p>
                            <?php  }
                            ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>





            </div>
        </div>
    </div>

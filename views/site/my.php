<?php

/* @var $this yii\web\View */

$this->title = 'My courses';
?>   <div></div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-6 mb-5">
                <h1 class="section-title-underline mb-5">
                    <span>Hi, <?php echo Yii::$app->user->identity->name ?>!</span> Your courses -
                </h1>
            </div>
        </div>
        <div class="row">
            <?php foreach ($courses as $course): ?>
            <div class="col-lg-4">
                <div class="course-1-item">
                    <figure class="thumnail">
                        <a href="course-single.html"><img src="<?php echo $course['course_img_url'] ?>" alt="Image" class="img-fluid"></a>
                        <div class="price"><a href="#">Продолжить</a></div>
                        <div class="category"><h3><?php echo $course['course_name'] ?></h3></div>
                        <div class="progress" style="border-radius: 0; height: 5px;" >
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 75%; border-radius: 0;
                         background-image: linear-gradient(to right, #051937, #004d7a, #008793);" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </figure>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>


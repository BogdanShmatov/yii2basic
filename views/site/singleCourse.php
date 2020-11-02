<?php

$this->title = $courseSingle->course_name;

?>

<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('../images/bg_1.jpg')">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-7">
                <h2 class="mb-0"><?php echo $courseSingle->course_name?></h2>
                <p><?php echo $courseSingle->course_description?></p>
            </div>
        </div>
    </div>
</div>


<div class="custom-breadcrumns border-bottom">
    <div class="container">
        <a href="index.html">Home</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <a href="courses.html">Courses</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">Courses</span>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-8 mb-5">
                <h1 class="section-title-underline mb-5">
                    <span>Hi, Broo!</span> Take a look at the preview -
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <p>
                    <iframe width="580" height="360" src="<?php echo $courseSingle->course_preview?>"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </p>
            </div>
            <div class="col-lg-5 ml-auto align-self-center">
                <h2 class="section-title-underline mb-5">
                    <span>Course Details</span>
                </h2>
                <p><strong class="text-black d-block">Author:</strong> <?php echo $courseSingle->course_author?></p>
                <p class="mb-5"><strong class="text-black d-block">Added:</strong> <?php echo $courseSingle->date?></p>
                <p>
                    <a href="#" class="btn btn-primary rounded-0 btn-lg px-5">Enroll</a>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="section-bg style-1" style="background-image: url('../images/hero_1.jpg');">
    <div class="container">
        <?php if(!$courseSingle->course_isFree) {?>
            <div class="col-lg-6 col-md-6 mb-5 mb-lg-0">
                <h1>Похоже это платный контент!</h1>
                <p>После покупки уроки станут доступны.</p>
                <a href="#" class="btn btn-primary rounded-0 btn-lg px-5">Купить</a>
            </div>
        <?php } else {?>
            <div class="row">
                <?php foreach ($courseSingle->lessons0 as $lesson): ?>
                    <div class="col-lg-4">
                        <div class="course-1-item">
                            <figure class="thumnail">
                                <div class="category"><h3><a style="color: white" href="#"><?php echo $lesson->lesson_name?></a></h3></div>
                            </figure>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </div>
</div>
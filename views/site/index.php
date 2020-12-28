<?php

/* @var $this yii\web\View */

$this->title = 'Academic';
?>
<div class="hero-slide owl-carousel site-blocks-cover">
    <?php for($i = 0, $size = count($images); $i < $size; $i++) {
        $intro = ['Academics', 'You Can Learn', 'Free Education' ];?>
    <div class="intro-section" style="background-image: url('<?php echo $images[$i]['img_url'] ?>');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
                    <h1><?php echo $intro[rand(0, 2)]; ?></h1>
                    <div class="col-12">
                        <a href="course/get-courses/" class="btn btn-primary btn-lg px-5">Все курсы </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<div></div>


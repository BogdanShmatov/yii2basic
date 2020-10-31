<?php

/* @var $this yii\web\View */

$this->title = 'Category';
?>   <div></div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-6 mb-5">
                <h1 class="section-title-underline mb-5">
                    <span>Hi!</span>  Categories -
                </h1>
            </div>
        </div>
        <div class="row">
            <?php foreach($categories as $category): ?>
            <div class="col-lg-4">
                <div class="course-1-item">
                    <figure class="thumnail">
                        <div class="category"><h3><a style="color: white" href="#"><?php echo $category->cat_name?></a></3></div>
                    </figure>
                </div>
            </div>
            <?php endforeach; ?>


        </div>
    </div>
</div>
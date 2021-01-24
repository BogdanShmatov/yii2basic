<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
$this->title = 'Category';

?>
<div></div>

<div class="site-section">
    <?php Pjax::begin([
            'id' => 'course-by-category',
            'enablePushState' => false,
            'enableReplaceState' => false,
    ]) ?>
    <div class="container" id="container">

        <div class="row mb-5 justify-content-center text-center">
            <?php foreach ($categories as $category): ?>

                <?= Html::a($category['cat_name'], ['course/get-categories','id' => $category['id']], ['class' => 'cat_btn']) ?>


            <?php endforeach; ?>
        </div>


        <div class="row" id="course-by-category">
            <?php foreach ($coursesCat as $course):?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="course-1-item" >
                        <figure class="thumnail">
                            <?php if (in_array($course['id'], $courseUser)) {?>
                            <a href="<?= Url::toRoute(['continue-course', 'id'=>$course['id']]);?>">
                                <?php } else {?>

                                <a href="<?= Url::toRoute(['view', 'id'=>$course['id']]);?>">



                                <?php }?>

                                    <img src="<?php echo $course['course_img_url']?>" alt="Image" class="img-fluid"></a>
                                <div class="price">
                                    <?php if($course['course_isFree']){ ?> Free <?php } else echo $course['course_price']?>KZT</div>
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
                                if (in_array($course['id'], $courseUser)) {
                                    ?>
                                    <p><a href="<?= Url::toRoute([
                                            'continue-course',
                                            'id'=>$course['id']]);?>" class="btn btn-primary px-4">Продолжить</a></p>

                                <?php } else if ($course['course_isFree']) { ?>
                                    <p><a href="<?= Url::toRoute([
                                            'buy-course',
                                            'id'=>$course['id']]);?>" class="btn btn-primary px-4">В коллекцию</a></p>

                                <?php  } else {?>
                                    <p><a href="<?= Url::toRoute([
                                            'buy-course',
                                            'id'=>$course['id']]);?>" class="btn btn-primary px-4">Купить</a></p> <?php  } ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
    <?php Pjax::end() ?>

</div>
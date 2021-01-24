<?php

$this->title = $courseSingle['course_name'];

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

?>

<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('../images/bg_1.jpg')">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-7">
                <h2 class="mb-0"><?php echo $courseSingle['course_name']?></h2>
                <p><?php echo $courseSingle['course_description']?></p>
            </div>
        </div>
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
                <div class="video-1">
                    <iframe width="100%" height="350vh" src="<?php echo $courseSingle['course_preview']?>"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-5 ml-auto align-self-center">
                <h2 class="section-title-underline mb-5">
                    <span>Course Details</span>
                </h2>
                <p><strong class="text-black d-block">Author:</strong> <?php echo $courseSingle['course_author']?></p>
                <p class="mb-5"><strong class="text-black d-block">Added:</strong> <?php echo $courseSingle['date']?></p>
                <p>
                    <?php
                    if($courseSingle['course_isFree']){

                    ?>
                <p><a href="<?= Url::toRoute(['buy-course', 'id'=>$courseSingle['id']]);?>" class="btn btn-primary px-4">В коллекцию</a></p>

                <?php  }else{
                    ?>
                    <p><a href="<?= Url::toRoute(['buy-course', 'id'=>$courseSingle['id']]);?>" class="btn btn-primary px-4">Купить</a></p>
                <?php  }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="section-bg style-1" style="background-image: url('/images/hero_1.jpg');">
    <div class="container">
        <?php if(!$courseSingle['course_isFree']) {?>
            <div class="col-lg-6 col-md-6 mb-5 mb-lg-0">
                <h1>Похоже это платный контент!</h1>
                <p>После покупки уроки станут доступны.</p>
                <a href="<?= Url::toRoute(['buy-course', 'id'=>$courseSingle['id']]);?>" class="btn btn-primary px-4">Купить</a>
            </div>
        <?php } else {?>
            <div class="row">
                    <div class="col-lg-6 col-md-6 mb-5 mb-lg-0">
                        <h1>Похоже это бесплатный контент!</h1>
                        <p>Все уроки доступны.</p>
                        <a href="<?= Url::toRoute(['buy-course', 'id'=>$courseSingle['id']]);?>" class="btn btn-primary px-4">В коллекцию</a>
                    </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row ">
            <?php if (!$courseSingle['course_isFree'] == 0) {?>
                <div class="col-lg-9 col-md-6 mb-4">
                    <?php for ($i = 0, $size = count($courseSingle['lessons0']); $i < $size; $i++) {

                        $lesson = $courseSingle['lessons0'];?>
                        <div class="video-container" style="width: 100%; height: 70vh; background-color: #51be78">
                            <iframe width="100%" height="100%" src=" <?php echo $lesson[$i]['lesson_url']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div style="width: 100%; height: 65vh; box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.1); color: #000; overflow: auto ">
                        <h4 style="padding: 5px;">Уроки:</h4>
                        <div class="lessons">
                            <?php for ($i = 0, $size = count($courseSingle['lessons0']); $i < $size; $i++) {
                                $lesson = $courseSingle['lessons0']; ?>
                                    <div class="lesson">
                                        <?php echo $lesson[$i]['lesson_name'] ?>
                                    </div>
                                <?php  }?>
                        </div>
                    </div>
                    <a style="width: 100%" href="<?= Url::toRoute(['buy-course', 'id'=>$courseSingle['id']]);?>" class="btn btn-dark rounded-0 px-5">В коллекцию ;)</a>
                </div>
            <?php } else {?>

                <div class="col-lg-9 col-md-6 mb-4">
                    <div class="video-1" style="width: 100%; height: 70vh; background-color: #51be78">
                        <iframe width="100%" height="100%" src=" <?php echo $courseSingle['course_video_url']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div style="width: 100%; height: 20vh; box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.1); color: #000; overflow: auto ">
                        <h4 style="padding: 5px;">Уроки:</h4>
                        <div class="lessons">
                            <div class="lesson">
                                Бесплатный урок
                            </div>
                        </div>
                    </div>
                        <a style="width: 100%" href="<?= Url::toRoute(['buy-course', 'id'=>$courseSingle['id']]);?>" class="btn btn-dark rounded-0 px-5">Получить больше! ;)</a>
                </div>

            <?php }?>
        </div>
    </div>
</div>
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <?php $form = ActiveForm::begin(['id' => 'card-form',
                        'options' => [
                            'class' => 'comment-form',
                        ],
                    ]); ?>
                    <div class="panel-body">
                        <?= $form->field($comment, 'content')
                            ->textarea(['placeholder'=>'Добавьте Ваш комментарий','autofocus' => true])
                            ->label('') ?>
                        <div class="mar-top clearfix">
                            <?= Html::submitButton('Доавить', ['class' => 'btn btn-primary btn-lg px-5', 'name' => 'pay-button']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div><!-- /.row -->
    </section><!-- /.container -->

<?php


echo ListView::widget([
'dataProvider' => $listDataProvider,
'itemView' => '_comment',
    'pager' => [
        'nextPageLabel' => 'Следующая',
        'prevPageLabel' => 'Предыдущая',
        'maxButtonCount' => 5,
    ],
]);

$this->registerJsFile('/js/videohide.js');
?>
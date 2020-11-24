<?php


use yii\helpers\Url;

$this->title = 'Category';
?>
<div></div>

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
            <div class="col-lg-3">
                <div class="course-1-item">
                    <?php foreach($categories as $category): ?>
                        <div class="category border-bottom category-hover">
                            <h3><a style="color: white" href="<?= Url::toRoute(['pay-by-card', 'id'=>$category['cat']['id']]);?>"><?php echo $category['cat']['cat_name']?></a></h3>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-1-item">
                    <figure class="thumnail">
                        <a href="/course/view/?id=2"><img src="/images/course_2.jpg" alt="Image" class="img-fluid"></a>
                        <div class="price">$                                Free
                        </div>
                        <div class="category">
                            <h3><a style="color: #FFFFFF" href="/course/view/?id=2">React Native 2020</a></h3>
                        </div>
                    </figure>
                    <div class="course-1-content pb-4">
                        <a href="/course/view/?id=2">
                            <h2>Мобильные приложения для Android/iOS на JS + React JS</h2>
                        </a>
                        <div class="rating text-center mb-3">
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                        </div>
                        <p>Разработка мобильных приложений</p>
                        <p class="desc mb-4">Владилен Минин</p>
                        <p><a href="/course/buy-course/?id=2" class="btn btn-primary px-4">В коллекцию</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-1-item">
                    <figure class="thumnail">
                        <a href="/course/view/?id=2"><img src="/images/course_2.jpg" alt="Image" class="img-fluid"></a>
                        <div class="price">$                                Free
                        </div>
                        <div class="category">
                            <h3><a style="color: #FFFFFF" href="/course/view/?id=2">React Native 2020</a></h3>
                        </div>
                    </figure>
                    <div class="course-1-content pb-4">
                        <a href="/course/view/?id=2">
                            <h2>Мобильные приложения для Android/iOS на JS + React JS</h2>
                        </a>
                        <div class="rating text-center mb-3">
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                        </div>
                        <p>Разработка мобильных приложений</p>
                        <p class="desc mb-4">Владилен Минин</p>
                        <p><a href="/course/buy-course/?id=2" class="btn btn-primary px-4">В коллекцию</a></p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
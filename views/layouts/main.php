<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;

use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
<?php $this->beginBody() ?>

<dv class="site-wrap">
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>
    <div class="py-2">
        <div class="container">
        </div>
    </div>
    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

        <div class="container">
            <div class="d-flex align-items-center">
                <div class="site-logo">
                    <a href="/" class="d-block">
                        <img src="/images/logo.jpg" alt="Image" class="img-fluid">
                    </a>
                </div>
                <div class="mr-auto">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <?php if (Yii::$app->user->isGuest) { ?>
                            <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                                <li class="active">
                                    <a href="/" class="nav-link text-left">Home</a>
                                </li>
                                <li class="has-children">
                                    <a href="<?= Url::toRoute(['course/get-categories']);?>" class="nav-link text-left">Categories</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Категории</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['course/get-courses']);?>" class="nav-link text-left">All Courses</a>
                                </li>
                            </ul>                                                                                                                                                                                                                                                                                          </ul>
                        <?php } else { ?>
                            <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                                <li class="active">
                                    <a href="<?= Url::toRoute(['site/my']);?>" class="nav-link text-left">My courses</a>
                                </li>
                                <li class="has-children">
                                    <a href="<?= Url::toRoute(['course/get-courses']);?>" class="nav-link text-left">Store</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Категории</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['course/get-purchase-history']);?>" class="nav-link text-left">Purchase history</a>
                                </li>
                                <?php  if (\Yii::$app->user->can('adminAccess')) {?>
                                    <li><a href="<?= Url::toRoute(['admin/default/index']);?>" class="small btn btn-primary px-4 py-2"> ADMIN mode</a></li>

                                <?php }?>
                            </ul>
                        <?php } ?>

                    </nav>
                </div>
                <div class="col-lg-3 text-right">
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <a href="<?= Url::toRoute(['site/logout']);?>" class="small mr-3"><span class="icon-unlock-alt"></span> Log In</a>
                        <a href="<?= Url::toRoute(['site/signup']);?>" class="small btn btn-primary px-4 py-2"><span class="icon-users"></span> Register</a>
                        <?php } else { ?>
                        <a href="/profile/view/" class="small mr-3">
                            <img style="border-radius: 50px; width: 50px; height: 50px;" src="https://whatsism.com/uploads/posts/2018-07/1530546770_rmk_vdjbx10.jpg" alt="">
                            <?php echo Yii::$app->user->identity->username ?></a>
                        <a href="<?= Url::toRoute(['site/logout']);?>" class="small btn btn-primary px-4 py-2"> Выйти</a>
                    <?php } ?>
                    <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span
                                class="icon-menu h3"></span></a>
                </div>
            </div>
        </div>
    </header>
    <?= $this->render('//layouts/_messages') ?>

    <?= $content ?>


<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="copyright">
                    <p class="mb-4"><img src="/images/logo.png" alt="Image" class="img-fluid"></p>
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy; My  <?= date('Y') ?> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- .site-wrap -->


<!-- loader -->
<div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg></div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

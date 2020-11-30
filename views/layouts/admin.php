<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\bootstrap\Alert;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use yii\helpers\Html;
use mdm\admin\components\Helper;
use app\modules\admin\assets\AdminAsset;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AdminAsset::register($this);

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
<body>
<?php $this->beginBody() ?>


<body id="mimin" class="dashboard">
<!-- start: Header -->
<nav class="navbar navbar-default header navbar-fixed-top">
    <div class="col-md-12 nav-wrapper">
        <div class="navbar-header" style="width:100%;">
            <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
            </div>
            <a href="index.html" class="navbar-brand">
                <b>Admin</b>
            </a>



            <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span><?php echo Yii::$app->user->identity->username ?></span></li>
                <li class="dropdown avatar-dropdown">
                    <img src="https://whatsism.com/uploads/posts/2018-07/1530546770_rmk_vdjbx10.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>

                </li>
                <li ><a href="/site/logout/" class="opener-right-menu"><svg aria-labelledby="svg-inline--fa-title-2VKNbAzV52MR" data-prefix="far" data-icon="sign-in-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-sign-in-alt fa-w-16 fa-fw fa-lg"><title id="svg-inline--fa-title-2VKNbAzV52MR" class="">Sign In</title><path fill="currentColor" d="M144 112v51.6H48c-26.5 0-48 21.5-48 48v88.6c0 26.5 21.5 48 48 48h96v51.6c0 42.6 51.7 64.2 81.9 33.9l144-143.9c18.7-18.7 18.7-49.1 0-67.9l-144-144C195.8 48 144 69.3 144 112zm192 144L192 400v-99.7H48v-88.6h144V112l144 144zm80 192h-84c-6.6 0-12-5.4-12-12v-24c0-6.6 5.4-12 12-12h84c26.5 0 48-21.5 48-48V160c0-26.5-21.5-48-48-48h-84c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h84c53 0 96 43 96 96v192c0 53-43 96-96 96z" class=""></path></svg></a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- end: Header -->

<div class="container-fluid mimin-wrapper">

    <!-- start:Left Menu -->
    <div id="left-menu">
        <div class="sub-left-menu scroll">
            <li class="time">
                <h1 class="animated fadeInLeft">21:00</h1>
                <p class="animated fadeInRight">Sat,October 1st 2029</p>
            </li>
            <?php
            $menuItems = [
                ['label' => 'Главная', 'url' => ['/admin/default/index']],
                ['label' => 'Пользователи', 'url' => ['/rbac/default/index']],
                ['label' => 'Курсы', 'url' => ['/admin/default/index']],
                ['label' => 'Посты', 'url' => ['/admin/default/index']],
                ['label' => 'Комментарии', 'url' => ['/admin/default/index']],
                ['label' => 'USER mode', 'url' => ['/site/my']],

            ];

            echo Menu::widget([
                'items' => Helper::filter($menuItems),
                'options' => ['class' => 'nav nav-list'],
                'linkTemplate' => '<a href="{url}" class="tree-toggle nav-header"><span>{label}</span></a>',
                'activeCssClass'=>'active',
                'itemOptions'=>['class'=>'ripple'],
            ]);

            ?>

        </div>
    </div>
    <!-- end: Left Menu -->


    <!-- start: content -->
    <div id="content">

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $this->render('//layouts/_messages') ?>
            <?= $content ?>
        </div>
    </div>
    <!-- end: content -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php
/* @var $this yii\web\View */

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
$userName = User::findOne($model['user_id']);
?>

    <section class="container">
        <div class="row">
                <div class="panel">
                    <div class="panel-body">
                        <!-- Comment 1 -->
                        <!--===================================================-->
                        <div class="media-block">
                            <a class="media-left" href="#"><img class="img-circle img-sm" alt="Профиль пользователя" src="https://bootstraptema.ru/snippets/icons/2016/mia/1.png"></a>
                            <div class="media-body">
                                <div class="mar-btm">
                                    <a href="#" class="btn-link text-semibold media-heading box-inline"><?php echo $userName['name']?></a>
                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> <?php echo $model['created_at'] ?></p>
                                </div>
                                <p><?php echo $model['content'] ?></p>
                                <div class="pad-ver">
                                    <?php if ($model['user_id'] == Yii::$app->user->getId()) { ?>
                                    <a href="<?= Url::toRoute(['profile/delete-comment', 'id'=>$model['id']]);?>" class="btn btn-primary px-4">Удалить</a>
                                   <?php }?>
                                </div>
                            </div>
                        </div>
                        <!-- Comment 1 end -->
                        <!--===================================================-->
                    </div><!-- /.row -->
    </section><!-- /.container -->

<?php
$css = <<<CSS
div.summary {
color: #FFFFFF;
}
div.pad-ver>a {
color: #FFFFFF;
}
.img-sm {
 width: 46px;
 height: 46px;
}
ul {
justify-content: center;
}
ul  > li > a{
color: #0d0cb5;
}
.panel {
 box-shadow: 0 2px 0 rgba(0,0,0,0.075);
 border-radius: 0;
 border: 0;
 margin-bottom: 15px;
}
.panel .panel-footer, .panel>:last-child {
 border-bottom-left-radius: 0;
 border-bottom-right-radius: 0;
}
.panel .panel-heading, .panel>:first-child {
 border-top-left-radius: 0;
 border-top-right-radius: 0;
}
.panel-body {
 padding: 25px 20px;
}
.media-block .media-left {
 display: block;
 float: left
}
.media-block .media-right {
 float: right
}
.media-block .media-body {
 display: block;
 overflow: hidden;
 width: auto
}
.middle .media-left,
.middle .media-right,
.middle .media-body {
 vertical-align: middle
}
.thumbnail {
 border-radius: 0;
 border-color: #e9e9e9
}
.tag.tag-sm, .btn-group-sm>.tag {
 padding: 5px 10px;
}
.tag:not(.label) {
 background-color: #fff;
 padding: 6px 12px;
 border-radius: 2px;
 border: 1px solid #cdd6e1;
 font-size: 12px;
 line-height: 1.42857;
 vertical-align: middle;
 -webkit-transition: all .15s;
 transition: all .15s;
}
.text-muted, a.text-muted:hover, a.text-muted:focus {
 color: #acacac;
}
.text-sm {
 font-size: 0.9em;
}
.text-5x, .text-4x, .text-5x, .text-2x, .text-lg, .text-sm, .text-xs {
 line-height: 1.25;
}
.btn-trans {
 background-color: transparent;
 border-color: transparent;
 color: #929292;
}
.btn-icon {
 padding-left: 9px;
 padding-right: 9px;
}
.btn-sm, .btn-group-sm>.btn, .btn-icon.btn-sm {
 padding: 5px 10px !important;
}
.mar-top {
 margin-top: 15px;
}
        
CSS;

Yii::$app->getView()->registerCss($css);
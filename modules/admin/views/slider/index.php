<?php

use yii\helpers\Html;use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SliderImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slider Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Slider Image', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel">
            <div class="panel-heading">
               <h3>Custom</h3>
            </div>
            <div class="panel-body" style="padding-bottom:70px;">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="carousel-example2" class="carousel-thumb carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php for($i = 0, $size = count($images); $i < $size; $i++) {?>
                            <div class="item <?php echo ($i == 0) ? " active " : " "; ?>" data-slide="<?php echo $i ?>">
                                <img class="img-responsive" data-src="holder.js/900x500/auto/#777:#555/text:First slide" alt="First slide" src="/<?php echo $images[$i]['img_url'] ?>">
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <a class="left carousel-control" href="#carousel-example2" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example2" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <ol class="carousel-thumb-img carousel-indicator">
                        <?php for($i = 0, $size = count($images); $i < $size; $i++) {?>

                            <li id="#slider-indicator<?php echo $i ?>" data-target="#carousel-example2" data-slide-to="<?php echo $i ?>" class="<?php echo ($i == 0) ? " active " : " "; ?> carousel-thumb-img-li">
                                <img class="img-responsive" data-src="holder.js/900x500/auto/#777:#555/text:" alt="First slide 1" src="/<?php echo $images[$i]['img_url'] ?>">
                                <?php

                                echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['slider/delete', 'id' => $images[$i]['id']],[
                                    'data-method' => 'POST',
                                    'data-params' => [
                                        'csrf_param' => \Yii::$app->request->csrfParam,
                                        'csrf_token' => \Yii::$app->request->csrfToken,
                                    ]]);
                                echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['slider/update', 'id' => $images[$i]['id']],[
                                    'data-method' => 'POST',
                                    'data-params' => [
                                        'csrf_param' => \Yii::$app->request->csrfParam,
                                        'csrf_token' => \Yii::$app->request->csrfToken,
                                    ]]);
                                echo Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['slider/view', 'id' => $images[$i]['id']],[
                                    'data-method' => 'POST',
                                    'data-params' => [
                                        'csrf_param' => \Yii::$app->request->csrfParam,
                                        'csrf_token' => \Yii::$app->request->csrfToken,
                                    ]]);

                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>

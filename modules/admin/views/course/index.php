<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */


$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <div id="w0" class="grid-view">
            <div class="summary">Showing <b><?php echo count($courses) ?></b> items.</div>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>

                    <th><a href="/index?sort=course_name" data-sort="course_name">Course Name</a></th>
                    <th><a href="/index?sort=course_author" data-sort="course_author">Course Author</a></th>
                    <th><a href="/index?sort=date" data-sort="date">Date</a></th>
                    <th><a href="/index?sort=price" data-sort="price">Price</a></th>
                    <th class="action-column">&nbsp;</th>
                </tr>
                <tr id="w0-filters" class="filters">

                    <td><input type="text" class="form-control" name="CourseSearch[course_name]"></td>
                    <td><input type="text" class="form-control" name="CourseSearch[course_author]"></td>
                    <td><input type="text" class="form-control" name="CourseSearch[date]"></td>
                    <td><input type="text" class="form-control" name="CourseSearch[price]"></td>
                    <td>&nbsp;</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($courses as $course): ?>
                <tr data-key="<?php echo $course['id']?>">
                    <td><?php echo $course['course_name']?></td>
                    <td><?php echo $course['course_author']?></td>
                    <td><?php echo $course['date']?></td>
                    <td><?php if ($course['course_price'] === 0) {
                        echo  'FREE';
                        } else echo '$'.$course['course_price']?></td>
                    <td>
                        <a href="<?= Url::toRoute(['view', 'id'=>$course['id']]);?>" title="View" aria-label="View" data-pjax="0">
                            <span class="glyphicon glyphicon-eye-open"></span></a>
                        <a href="<?= Url::toRoute(['update', 'id'=>$course['id']]);?>" title="Update" aria-label="Update" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="<?= Url::toRoute(['delete', 'id'=>$course['id']]);?>" title="Delete" aria-label="Delete" data-pjax="0" data-confirm="Are you sure you want to delete this item?" data-method="post">
                            <span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
                <?php endforeach; ?>


</div>

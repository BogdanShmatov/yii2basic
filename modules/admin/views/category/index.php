<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */


$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <div id="w0" class="grid-view">
            <div class="summary">Showing <b><?php echo count($categories) ?></b> items.</div>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>

                    <th><a href="/index?sort=category_id" data-sort="category_name">Category ID</a></th>
                    <th><a href="/index?sort=category_author" data-sort="cat_name">Category Name</a></th>
                    <th class="action-column">&nbsp;</th>
                </tr>
                <tr id="w0-filters" class="filters">

                    <td><input type="text" class="form-control" name="CourseSearch[category_id]"></td>
                    <td><input type="text" class="form-control" name="CourseSearch[cat_name]"></td>
                    <td>&nbsp;</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                <tr data-key="<?php echo $category['id']?>">
                    <td><?php echo $category['id']?></td>
                    <td><?php echo $category['cat_name']?></td>
                    <td>
                        <a href="<?= Url::toRoute(['view', 'id'=>$category['id']]);?>" title="View" aria-label="View" data-pjax="0">
                            <span class="glyphicon glyphicon-eye-open"></span></a>
                        <a href="<?= Url::toRoute(['update', 'id'=>$category['id']]);?>" title="Update" aria-label="Update" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="<?= Url::toRoute(['delete', 'id'=>$category['id']]);?>" title="Delete" aria-label="Delete" data-pjax="0" data-confirm="Are you sure you want to delete this item?" data-method="post">
                            <span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
                <?php endforeach; ?>


</div>

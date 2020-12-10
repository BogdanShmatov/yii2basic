<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $course['course_name'];
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $course['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $course['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
        <table id="w0" class="table table-striped table-bordered detail-view">
            <tbody>
            <tr>
                <th>ID</th>
                <td><?php echo $course['id'] ?></td>
            </tr>
            <tr>
                <th>Course Name</th>
                <td><?php echo $course['course_name'] ?></td>
            </tr>
            <tr>
                <th>Course Category</th>
                <td><?php echo $course['cat']['cat_name'] ?></td>
            </tr>
            <tr>
                <th>Course Author</th>
                <td><?php echo $course['course_author'] ?></td>
            </tr>
            <tr>
                <th>Course Description</th>
                <td><?php echo $course['course_description'] ?></td>
            </tr>
            <tr>
                <th>Course price</th>
                <td><?php echo $course['course_price'] ?></td>
            </tr>
            <tr>
                <th>Course is free</th>
                <td><?php if ($course['course_isFree'] === 1) {
                    echo 'YES';
                    } else echo 'NO'; ?></td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

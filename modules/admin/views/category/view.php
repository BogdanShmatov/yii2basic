<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $category['cat_name'];
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $category['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $category['id']], [
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
                <td><?php echo $category['id'] ?></td>
            </tr>
            <tr>
                <th>Course Name</th>
                <td><?php echo $category['cat_name'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

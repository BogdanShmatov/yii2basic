<?php

use yii\helpers\Url;

$courseId = $courseSingle['id'];
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
        <div class="row ">
            <div class="col-lg-9 col-md-6 mb-4">
                <?php for ($i = 0, $size = count($courseSingle['lessons0']); $i < $size; $i++) {

                    $lesson = $courseSingle['lessons0'];?>
                    <div class="video-container" style="width: 100%; height: 70vh; background-color: #51be78">
                        <iframe width="100%" height="100%" src=" <?php echo $lesson[$i]['lesson_url']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="width: 100%; height: 70vh; box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.1); color: #000; overflow: auto ">
                    <h4 style="padding: 5px;">Уроки:</h4>
                    <div class="lessons">
                        <?php for ($i = 0, $size = count($courseSingle['lessons0']); $i < $size; $i++) {
                            $lesson = $courseSingle['lessons0'];
                                    ?>
                                    <div class="lesson">
                                        <input id="checkbox" type="checkbox" data-id=" <?php echo $lesson[$i]['id'] ?>" <?php  if((in_array($lesson[$i]['id'], $progress))) echo 'checked="checked" class="pointer-events-none"'  ?>>
                                        <?php echo $lesson[$i]['lesson_name'] ?>
                                    </div>
                            <?php  } ?>
                    </div>
                </div>
                <a style="width: 100%" href="<?= Url::toRoute(['delete-progress', 'id'=>$courseSingle['id']]);?>" class="btn btn-danger rounded-0 px-5">Сбросить прогресс ;)</a>
            </div>
        </div>
    </div>
</div>


<?php
$js = <<< JS
let course_id = $courseId;
let checkboxes = document.querySelectorAll('#checkbox');

checkboxes.forEach(item =>{
    item.addEventListener('click', function (evt) { 
         $.ajax({
            // Метод отправки данных (тип запроса)
            type : 'POST',
            // URL для отправки запроса
            url : '../save-progress/',
            // Данные формы
            data : {'course_id': course_id,
                    'lesson_id': item.dataset.id,},
        })
       item.classList.add('pointer-events-none');
     })
}
    
)
JS;
$this->registerJs( $js, $position = yii\web\View::POS_READY );
?>






<?php
use yii\bootstrap\Alert;

echo '<div class="fullscreen">';

foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    //Проверим, существует ли сессия по ключу
    if(Yii::$app->getSession()->hasFlash($key)){
        echo Alert::widget([
            'options' => [
                'class' => (in_array($key, ['success', 'info', 'warning', 'danger']) ? 'alert-' . $key : 'alert-info'),
            ],
            'body' => $message,
        ]);
    }


}

echo '</div>';

$css = <<<CSS
div.fullscreen {
    position: fixed;
    z-index: 10000;
    width: 100%; 
    height: auto;
    padding: 0 2%;
    top: 60px; 
    left: 0;
}        
        
CSS;

Yii::$app->getView()->registerCss($css);
<?php


namespace app\common\helpers;


class ButtonHelper
{
    public static function createButton($url, $name)
    {
        return  '<p><a href="'.$url.'" class="btn btn-primary px-4">'.$name.'</a></p>';
    }

}
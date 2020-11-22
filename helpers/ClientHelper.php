<?php


namespace app\helpers;

use Yii;

use yii\httpclient\Client;

class ClientHelper extends Client
{
    static function getInfo($type = 'GET', $data)
    {
        $client = new Client(['baseUrl' => Yii::$app->params['baseUrl'],]);

        if ($type === 'GET') {

            $clientResp = $client->get($data)
                ->setFormat(Client::FORMAT_JSON)
                ->send();
            return $clientData = $clientResp->getData();
        }

    }

    static function getCoursesById($courses, $data) {

        $course_id = [];
        for ($i = 0, $size = count($courses); $i < $size; $i++)  {

            $course_id[$i] = $courses[$i]['course_id'];

        }

        $coursesResp = [];

        for ($i = 0, $size = count($course_id); $i < $size; $i++) {

            $coursesResp[$i] = self::getInfo('GET', 'course/' . $course_id[$i] . $data);
        }

        return $coursesResp;
    }
}
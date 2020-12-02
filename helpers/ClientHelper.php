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
        if ($type === 'DELETE') {

            $clientResp = $client->createRequest()
                ->setMethod($type)
                ->setUrl($data)
                ->send();

            return $clientResp;
        }
        if ($type === 'POST') {

            $clientResp = $client
                ->post('course', ['course_name' =>  $data['Course']['course_name'],
                                        'course_author' =>  $data['Course']['course_author'],
                                        'course_img_url' =>  $data['Course']['course_img_url'],
                                        'course_video_url' =>  $data['Course']['course_video_url'],
                                        'course_description' =>  $data['Course']['course_description'],
                                        'course_price' =>  $data['Course']['course_price'],
                                        'course_preview' =>  $data['Course']['course_preview'],
                                        'course_isFree' =>  $data['Course']['course_isFree'],
                                        ])
                ->send();

            return $clientResp;
        }
        if ($type === 'PUT') {
            $id = $data['Course']['id'];
            $clientResp = $client
                ->put('course/'.$id , ['course_name' =>  $data['Course']['course_name'],
                    'course_author' =>  $data['Course']['course_author'],
                    'course_img_url' =>  $data['Course']['course_img_url'],
                    'course_video_url' =>  $data['Course']['course_video_url'],
                    'course_description' =>  $data['Course']['course_description'],
                    'course_price' =>  $data['Course']['course_price'],
                    'course_preview' =>  $data['Course']['course_preview'],
                    'course_isFree' =>  $data['Course']['course_isFree'],
                ])
                ->send();

            return $clientResp;
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
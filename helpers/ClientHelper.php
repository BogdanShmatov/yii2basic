<?php

namespace app\helpers;

use Yii;

use yii\httpclient\Client;

class ClientHelper extends Client
{

    static function sendRequest($method = 'GET', $url, $data = '')
    {
        $client = new Client(['baseUrl' => Yii::$app->params['baseUrl']]);
        $response = $client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setData($data)
            ->send();

        return $clientData = $response->getData();
    }
}
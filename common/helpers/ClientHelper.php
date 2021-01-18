<?php

namespace app\common\helpers;

use Yii;

use yii\httpclient\Client;

class ClientHelper extends Client
{

    static function sendRequest($method = 'GET', $url, $data = null, $token = null)
    {
        $client = new Client(['baseUrl' => Yii::$app->params['baseUrl']]);
        $response = $client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setData($data)
            ->addHeaders(['Authorization' => 'Bearer '.$token])
            ->send();

        return $clientData = $response->getData();
    }
}
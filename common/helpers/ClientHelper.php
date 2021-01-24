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

    static function authWooppay($login, $pass)
    {
        $client = new Client(['baseUrl' => 'https://api.yii2-stage.test.wooppay.com/v1']);
        $loginResponse = $client->post('auth', [
            'login' => $login,
            'password' => $pass,
        ])->send();

        return substr($loginResponse->data['token'],4);
    }

    static function createInvoice($url, $data, $token)
    {
        $client = new Client(['baseUrl' => 'https://api.yii2-stage.test.wooppay.com/v1']);
        $invoice = $client->createRequest()
            ->setMethod('POST')
            ->setUrl($url)
            ->setData($data)
            ->addHeaders(['Authorization' => 'Bearer '.$token])
            ->send();

        return $invoice->getData();
    }

    static function checkInvoiceStatus($invoiceId, $key)
    {
        $client = new Client(['baseUrl' => 'https://api.yii2-stage.test.wooppay.com/v1']);
        $status = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('invoice?id='.$invoiceId.'&key='.$key)
            ->send();

        if ($status->isOk && $status->data['status'] == 3) {
            return true;
        } else {
            return false;
        }
    }

}
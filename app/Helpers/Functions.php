<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

trait Functions
{
    public function getInfoUser()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL') . '/server/user/info',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'cookie: _ga=GA1.1.2015916205.1669955207; think_var=vi-vn; Hm_lvt_7d775fcceda7358555b2cc349516bca4=1670064924,1670225713,1670772830,1670808405; PHPSESSID=bhk4nfvbmrvotc3ng7jmkht78a; Hm_lpvt_7d775fcceda7358555b2cc349516bca4=1670810541; _ga_88CHE2M5WX=GS1.1.1670808404.9.1.1670810541.0.0.0; PHPSESSID=gb9kip2ef8gdtu4lceuvrkcoth; think_var=en'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function getUserBankList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL') . '/server/user/userbanklist',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'cookie: _ga=GA1.1.2015916205.1669955207; think_var=vi-vn; Hm_lvt_7d775fcceda7358555b2cc349516bca4=1670064924,1670225713,1670772830,1670808405; PHPSESSID=bhk4nfvbmrvotc3ng7jmkht78a; Hm_lpvt_7d775fcceda7358555b2cc349516bca4=1670810541; _ga_88CHE2M5WX=GS1.1.1670808404.9.1.1670810541.0.0.0; PHPSESSID=gb9kip2ef8gdtu4lceuvrkcoth; think_var=en'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function getListResultMb45s($page = 1, $limit = 10)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL') . '/server/lottery/drawResult?lottery_id=47&page='. $page .'&limit='. $limit .'&date=',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=gb9kip2ef8gdtu4lceuvrkcoth'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true)['data']['list'];
    }

    public function layBaketquagannhat()
    {
        $listResultMb45s = $this->getListResultMb45s()->data->list;
    }

    public function sendNotificationTelegram($message = '')
    {
        $client = new Client();
        $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN', '').'/sendMessage?chat_id='.env('TELEGRAM_CHAT_ID', '').'&text='.$message;
        $client->request('GET', $url);
    }
}

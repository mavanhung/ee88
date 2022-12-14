<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use App\Constants\DefineCode;
use Illuminate\Support\Facades\Config;

trait Functions
{
    public function sendNotificationTelegram($message = '')
    {
        $client = new Client();
        $url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN', '').'/sendMessage?chat_id='.env('TELEGRAM_CHAT_ID', '').'&text='.$message;
        $client->request('GET', $url);
    }

    public function getInfoUser($cookie)
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
            CURLOPT_HTTPHEADER => $cookie,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function getUserBankList($cookie)
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
            CURLOPT_HTTPHEADER => $cookie,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function getFormToken() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL') . '/server/lottery/list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => DefineCode::REQUEST_HEADER
        ));

        // Hàm lấy header response
        $headers = [];
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                return $len;

                $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                return $len;
            }
        );
        // Kết thúc hàm lấy header response

        $response = curl_exec($curl);

        curl_close($curl);

        return $headers['form-token'][0];

    }

    public function getResult($lotteryId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL') . '/server/lottery/getCurrentLotteryInfo?lottery_id='. $lotteryId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=04b80d7rg554tmv134k0prdksi; think_var=en'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public function getListResult($lotteryId, $page = 1, $limit = 10)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL') . '/server/lottery/drawResult?lottery_id='. $lotteryId .'&page='. $page .'&limit='. $limit .'&date=',
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

    public function combatMb45s($orders)
    {
        $cookie = DefineCode::COOKIE[0];
        $formToken = 'form-token: ' . $this->getFormToken();
        $CURLOPT_HTTPHEADER = array(
            $cookie,
            $formToken,
            'Content-Type: application/json'
        );

        $CURLOPT_POSTFIELDS = '{
            "lottery_id": "'. DefineCode::MB45S_LOTTERY_ID .'",
            "source": 1,
            "orders": [
                '. $orders .'
            ]
        }';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL') . '/server/order/placeOrder',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => $CURLOPT_HTTPHEADER,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $this->sendNotificationTelegram(json_decode($response, true)['msg']);
        return json_decode($response, true);
    }


    // define("INTERVAL", 5 ); // 5 seconds

    public function runIt() { // Your function to run every 5 seconds
        $result = $this->getResult(DefineCode::MB45S_LOTTERY_ID);
        $number4 = $result['data']['open_numbers_formatted'][3];
        $number5 = $result['data']['open_numbers_formatted'][4];

        $listResult = $this->getListResult(DefineCode::MB45S_LOTTERY_ID, 1, 4);
        $numberListResult1 = $listResult[0]['open_numbers_formatted'][4];
        $numberListResult2 = $listResult[1]['open_numbers_formatted'][4];
        $numberListResult3 = $listResult[2]['open_numbers_formatted'][4];
        $numberListResult4 = $listResult[3]['open_numbers_formatted'][4];

        if($number4 == '0' && $number5 == '0') {
            $this->combatMb45s(DefineCode::PLAY_ODD);
            $this->sendNotificationTelegram('Kỳ: '. $result['data']['issue']);
        }
        //Trường hợp 1 cây chẵn, 3 cây lẻ liên tục
        if($numberListResult1 % 2 == 0 && $numberListResult2 % 2 != 0 && $numberListResult3 % 2 != 0 && $numberListResult4 % 2 != 0){
            $this->combatMb45s(DefineCode::PLAY_ODD);
            $this->sendNotificationTelegram('Kỳ: '. $result['data']['issue']);
        }
        //Trường hợp 1 cây lẻ, 3 cây chẵn liên tục
        if($numberListResult1 % 2 != 0 && $numberListResult2 % 2 == 0 && $numberListResult3 % 2 == 0 && $numberListResult4 % 2 == 0){
            $this->combatMb45s(DefineCode::PLAY_EVEN);
            $this->sendNotificationTelegram('Kỳ: '. $result['data']['issue']);
        }
        // //Trường hợp 3 cây lẻ liên tục
        // if($numberListResult1 % 2 != 0 && $numberListResult2 % 2 != 0 && $numberListResult3 % 2 != 0){
        //     $this->combatMb45s(DefineCode::PLAY_ODD);
        //     $this->sendNotificationTelegram('Kỳ: '. $result['data']['issue']);
        // }
        // //Trường hợp 3 cây chẵn liên tục
        // if($numberListResult1 % 2 == 0 && $numberListResult2 % 2 == 0 && $numberListResult3 % 2 == 0){
        //     $this->combatMb45s(DefineCode::PLAY_EVEN);
        //     $this->sendNotificationTelegram('Kỳ: '. $result['data']['issue']);
        // }
        //Trường hợp 4 cây lẻ liên tục
        if($numberListResult1 % 2 != 0 && $numberListResult2 % 2 != 0 && $numberListResult3 % 2 != 0 && $numberListResult4 % 2 != 0){
            $this->combatMb45s(DefineCode::PLAY_ODD);
            $this->sendNotificationTelegram('Kỳ: '. $result['data']['issue']);
        }
        //Trường hợp 4 cây chẵn liên tục
        if($numberListResult1 % 2 == 0 && $numberListResult2 % 2 == 0 && $numberListResult3 % 2 == 0 && $numberListResult4 % 2 == 0){
            $this->combatMb45s(DefineCode::PLAY_EVEN);
            $this->sendNotificationTelegram('Kỳ: '. $result['data']['issue']);
        }
        $time = time();
        dump($time);
    }

    public function checkForStopFlag() { // completely optional
        // Logic to check for a program-exit flag
        // Could be via socket or file etc.
        // Return TRUE to stop.
        $userInfo = $this->getInfoUser(DefineCode::COOKIE);
        if($userInfo['data']['money'] <= 50000) {
            $this->sendNotificationTelegram('Số tiền còn lại:' . $userInfo['data']['money']);
            return true;
        }
        return false;
    }

    public function start() {
        $active = true;
        $nextTime   = microtime(true) + DefineCode::INTERVAL; // Set initial delay

        while($active) {
            usleep(1000); // optional, if you want to be considerate

            if (microtime(true) >= $nextTime) {
                $this->runIt();
                $nextTime = microtime(true) + DefineCode::INTERVAL;
            }

            // Do other stuff (you can have as many other timers as you want)

            $active = !$this->checkForStopFlag();
        }
    }
}

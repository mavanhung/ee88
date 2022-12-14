<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package  App\Constants
 */

class DefineCode
{
    const PRICE = '5000'; //Số tiền đặt cược

    //Chú ý: Phần này là đặt cược cho Miền bắc 45s
    const PLAY_ID_ODD = 2063; //Số Lẻ
    const PLAY_ID_EVEN = 2064; //Số Chẵn

    const PLAY_ODD = '{
        "play_id": '. DefineCode::PLAY_ID_ODD .',
        "price": "'. DefineCode::PRICE .'",
        "content": "Lẻ"
    }'; //Đặt cược lẻ

    const PLAY_EVEN = '{
        "play_id": '. DefineCode::PLAY_ID_EVEN .',
        "price": "'. DefineCode::PRICE .'",
        "content": "Chẵn"
    }'; //Đặt cược chẵn
    //kết thúc chú ý: Phần này là đặt cược cho Miền bắc 45s

    const MB3P_LOTTERY_ID = 46; // Miền bắc 3 phút mới
    const MB45S_LOTTERY_ID = 47; // Miền bắc 45 giây
    const MB75S_LOTTERY_ID = 48; // Miền bắc 75 giây

    //Cookie dùng để lấy thông tin user
    const COOKIE = array(
        'cookie: _ga=GA1.1.2015916205.1669955207; think_var=vi-vn; PHPSESSID=c0t8s5926knne6c2pf18347sf9; Hm_lvt_7d775fcceda7358555b2cc349516bca4=1670899926,1670908108,1670924459,1671014061; Hm_lpvt_7d775fcceda7358555b2cc349516bca4=1671014061; _ga_88CHE2M5WX=GS1.1.1671014061.21.0.1671014061.0.0.0'
    );

    //Request Header để lấy form token
    const REQUEST_HEADER = array(
        'authority: ee88111.com',
        'method: GET',
        'GET: /server/lottery/list',
        'scheme: https',
        'accept: application/json, text/plain, */*',
        'accept-encoding: gzip, deflate, br',
        'accept-language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5',
        'content-type: application/x-www-form-urlencoded/json',
        'cookie: _ga=GA1.1.2015916205.1669955207; think_var=vi-vn; PHPSESSID=c0t8s5926knne6c2pf18347sf9; Hm_lvt_7d775fcceda7358555b2cc349516bca4=1670899926,1670908108,1670924459,1671014061; Hm_lpvt_7d775fcceda7358555b2cc349516bca4=1671014061; _ga_88CHE2M5WX=GS1.1.1671014061.21.0.1671014061.0.0.0; PHPSESSID=tjrme431si7s6b617lfmkbo2j9; think_var=vi-vn',
        'form-token: fde62e20e9d966243c79f5cfbe23b841',
        'referer: https://ee88111.com/home/',
        'sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Windows"',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-origin',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
        'x-device: pc',
        'x-lang: vi'
    );

    const INTERVAL = 44;
}

<?php

use GuzzleHttp\Client;

$message = 'test message';
$client = new Client();
$url = 'https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN', '').'/sendMessage?chat_id='.env('TELEGRAM_CHAT_ID', '').'&text='.$message;
$client->request('GET', $url);

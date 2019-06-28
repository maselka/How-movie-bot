<?php
include('vendor/autoload.php');
use Telegram\Bot\Api;

$telegram = new Api('854559704:AAFfCPdSB-SfwwX-QNWIplVUmeV8cd-VjHk');
$result = $telegram -> getWebhookUpdates();
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];

$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => var_export($result, true) ]);
//if($text) {
//    if ($text == "/start") {
//        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' =>'Добро пожаловать!' ]);
//    } elseif($text == "/sayHello" and $name) {
//        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => '\'Hello, ' . $name . '!']);
//    } elseif ($text == "/sayHello" and !$name) {
//        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Hello, незнакомец!' ]);
//    }
//}
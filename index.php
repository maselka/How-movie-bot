<?php
include('vendor/autoload.php');
use Telegram\Bot\Api;

$telegram = new Api('854559704:AAFfCPdSB-SfwwX-QNWIplVUmeV8cd-VjHk');
$result = $telegram -> getWebhookUpdates();
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];
$keyboard = [["Привет бот"]];

if($text) {
    if ($text == "/start") {
        $reply = "Добро пожаловать в бота!";
        $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif($text == "/sayhello") {
        $reply = "Привет бот";
        if ($name) {
            $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Hello, ' . $name . '!']);
        } else {
            $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Hello, незнакомец!']);
        }
    }
}
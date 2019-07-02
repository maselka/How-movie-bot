<?php

include('vendor/autoload.php');
use Telegram\Bot\Api;

$telegram = new Api('854559704:AAFfCPdSB-SfwwX-QNWIplVUmeV8cd-VjHk');
$result = $telegram -> getWebhookUpdates();
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];
$keyboard = [['Какой фильм посмотреть?'],['Расскажи мне о фильме..']];

$token = new Tmdb\ApiToken('951aefe4839143b19cb846c5002fb7a9');
$client = new Tmdb\Client ($token);
$keyboardGenres = array();

$temp = array();
$genres = $client -> getGenresApi () -> getGenres ();
foreach ($genres as &$value) {
    $temp = $value->name;
    $keyboardGenres[] = $temp;
}

if($text) {
    if ($text == "/start") {
        $reply = "Привет, я расскажу тебе все об интересном тебе фильме!";
        $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif($text == "Какой фильм посмотреть?") {
        $reply = 'Какой жанр?';
        $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboardGenres, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);



    }
}

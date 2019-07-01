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
$body = new http\Message\Body;
$body->append('{}');


if($text) {
    if ($text == "/start") {
        $reply = "Привет, я расскажу тебе все об интересном тебе фильме!";
        $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif($text == "Привет бот") {
        if ($name) {
            $reply = 'Hello, ' . $name . '!';
        } else {
            $reply = 'Hello, незнакомец!';
        }
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif($text == "Какой фильм посмотреть?") {
        $reply = 'Какой жанр?';
        $telegram ->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
        //$keyboardGenres =
        //$reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
    }  //elseif($text == "Расскажи мне о фильме..") {}
}

$body = new http\Message\Body;
$body->append('{}');

$request->setRequestUrl('https://api.themoviedb.org/3/genre/movie/list');
$request->setRequestMethod('GET');
$request->setBody($body);

$request->setQuery(new http\QueryString(array(
    'language' => 'ru-RU',
    'api_key' => '951aefe4839143b19cb846c5002fb7a9'
)));

$client->enqueue($request)->send();
$response = $client->getResponse();

echo $response->getBody();

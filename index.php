<?php

include('vendor/autoload.php');
use Telegram\Bot\Api;

$telegram = new Api('854559704:AAFfCPdSB-SfwwX-QNWIplVUmeV8cd-VjHk');
$result = $telegram -> getWebhookUpdates();
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];

$token = new Tmdb\ApiToken('951aefe4839143b19cb846c5002fb7a9');
$client = new Tmdb\Client ($token);

if($text) {
    if ($text == "/start") {
        $reply = "Привет, если ты напишешь название фильма, то я расскажу тебе о нем все что знаю";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
    } elseif ($text) {
        $result = $client->getSearchApi()->searchMovies($text);
        error_log(var_export($result, true));
        foreach ($result as $value) {
            error_log($value['poster_path']);
        $posterUrl = "http://image.tmdb.org/t/p/w300_and_h450_bestv2" . $value['poster_path'];
            error_log($posterUrl = "http://image.tmdb.org/t/p/w300_and_h450_bestv2" . $value['poster_path']);
        $movieInfo = $value['overview'];
        $telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $posterUrl, 'caption' => $movieInfo ]);
        }
    }
}

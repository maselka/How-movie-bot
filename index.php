<?php

require_once('vendor/autoload.php');
require_once('tmdb_handler.php');
require_once('db_handler.php');

use Telegram\Bot\Api;

const TELEGRAM_API_TOKEN = '854559704:AAFfCPdSB-SfwwX-QNWIplVUmeV8cd-VjHk';

$telegram = new Api(TELEGRAM_API_TOKEN);
$result = $telegram -> getWebhookUpdates();
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];
$id = 1;

$db = initDB();

if($text) {
    if ($text == "/start") {
        if(!$name) {
          $name = 'Незнакомец';
        }
        $reply = "Привет, " . $name . ",! если ты напишешь какую нибудь фразу или слово, то я покажу тебе до трех фильмов связанных с этим выражением";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
    } elseif ($text) {
        //$result = getResponse($db, $text);
        if (!$result) {
            $result = $client->getSearchApi()->searchMovies($text);
            insertRow($db, $id, $text, $result);
        }
        for($i=0; $i<3; $i++) {
            if (!$result['results'][$i]) {
                break;
            }
            $telegram->sendPhoto(['chat_id' => $chat_id, 'parse_mode' => 'HTML', 'photo' => getUrlPoster($result['results'][$i]), 'caption' => getTextUnderPoster($result['results'][$i])]);
        }
    }
} else {
    $reply = "Нужно ввести какое нибудь выражение";
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
}

register_shutdown_function(function () {
    http_response_code(200);
});
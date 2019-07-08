<?php

require_once('vendor/autoload.php');
require_once('tmdb_handler.php');
require_once('db_handler.php');
require_once('functions.php');
require_once('consts.php');

use Telegram\Bot\Api;

$telegram = new Api(TELEGRAM_API_TOKEN);
$result = $telegram -> getWebhookUpdates();
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];
$db = initDB();

if($text) {
    if ($text == START) {
        if(!$name) {
          $name = 'Незнакомец';
        }
        $reply = "Привет, " . $name . ",! Если ты напишешь какую нибудь фразу или слово, то я покажу тебе до трех фильмов связанных с этим выражением";
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
    } elseif ($text) {
        $response = getResponseFromBD($db, $text);
        if (!$result) {
              $response = getResponseFromAPI($text);
              insertResponseInDB($db, $text, $response);
        }
        for($i=0; $i<3; $i++) {
            if (!$response['results'][$i]) {
                break;
            }
            $telegram->sendPhoto(['chat_id' => $chat_id, 'parse_mode' => 'HTML', 'photo' => getUrlPoster($response['results'][$i]), 'caption' => getTextUnderPoster($response['results'][$i])]);
        }
    }
} else {
    $reply = "Нужно ввести какое нибудь выражение";
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
}

register_shutdown_function(function () {
    http_response_code(200);
});
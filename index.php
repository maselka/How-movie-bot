<?php

include('vendor/autoload.php');
use Telegram\Bot\Api;

$db  =  new  MysqliDb ( 'eu-cdbr-west-02.cleardb.net' , 'b1597e3a08d730' , '123456789' , 'heroku_34fcf0748940255' );
const DB_HOST = 'eu-cdbr-west-02.cleardb.net';
const DB_USER = 'b1597e3a08d730';
const DB_PASS = '9a13c73f';

$telegram = new Api('854559704:AAFfCPdSB-SfwwX-QNWIplVUmeV8cd-VjHk');
$result = $telegram -> getWebhookUpdates();
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];

$token = new Tmdb\ApiToken('951aefe4839143b19cb846c5002fb7a9');
$client = new Tmdb\Client ($token);

function getUrlPoster($arrayWithInfo) {
    return "http://image.tmdb.org/t/p/w300_and_h450_bestv2" . $arrayWithInfo['poster_path'];
}

function getTextUnderPoster($arrayWithInfo) {
    return $arrayWithInfo['original_title'] . '
    ' . $arrayWithInfo['overview'];
}

function caсhResponse ($db, $response, $request) {
    $row = [
      'response' =>  json_encode($response),
      'request' => $request,
      'date' => new DateTime()
    ];
    $id = $db->insert('cach_response', $row);
    return $id;
}

function getResponse($db, $request) {
    $db->where('request', $request);
    $response  =  $db -> getValue('cach_requests', 'response');
    return  json_decode($response);
}

if($text) {
    if ($text == "/start") {
        $reply = "Привет, если ты напишешь какую нибудь фразу или слово, то я покажу тебе 3 фильма связанных с этим выражением";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
    } elseif ($text) {
        $result = getResponse($text);
        if (!$result) {
            $result = $client->getSearchApi()->searchMovies($text);
            caсhResponse ($result, $text);
        }
        for($i=0; $i<3; $i++) {
            $telegram->sendPhoto(['chat_id' => $chat_id, 'parse_mode' => 'HTML', 'photo' => getUrlPoster($result['results'][$i]), 'caption' => getTextUnderPoster($result['results'][$i])]);
        }

    }
}

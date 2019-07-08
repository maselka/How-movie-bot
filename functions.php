<?php

require_once('vendor/autoload.php');
require_once('tmdb_handler.php');
require_once('db_handler.php');
require_once('index.php');
require_once('consts.php');

function getResponse ($request) {
    $result = getResponseFromBD($db, $text);
    if (!$result) {
        $response = getResponseFromAPI($text);
        insertResponseInDB($db, $text, $response);
    }
}
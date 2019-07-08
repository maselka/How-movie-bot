<?php

require_once('vendor/autoload.php');
require_once('consts.php');

$token = new Tmdb\ApiToken(TMDB_API_TOKEN);
$client = new Tmdb\Client ($token);

function getUrlPoster($arrayWithInfo, $i)
{
    return "http://image.tmdb.org/t/p/w300_and_h450_bestv2" . $arrayWithInfo[$i]['poster_path'];
}

function getTextUnderPoster($arrayWithInfo, $i)
{
    return $arrayWithInfo[$i]['original_title'] . PHP_EOL . $arrayWithInfo[$i]['overview'];
}

function getResponseFromAPI($request) {
    global $client;
    return $client->getSearchApi()->searchMovies($request);
}
<?php

use Tmdb\ApiToken;
use Tmdb\Client;

require_once('vendor/autoload.php');

const TMDB_API_TOKEN = '951aefe4839143b19cb846c5002fb7a9';

$token = new Tmdb\ApiToken(TMDB_API_TOKEN);
$client = new Tmdb\Client ($token);

function getUrlPoster($arrayWithInfo)
{
    return "http://image.tmdb.org/t/p/w300_and_h450_bestv2" . $arrayWithInfo['poster_path'];
}

function getTextUnderPoster($arrayWithInfo)
{
    return $arrayWithInfo['original_title'] . '
    ' . $arrayWithInfo['overview'];
}

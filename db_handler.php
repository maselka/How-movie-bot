<?php

require_once('vendor/autoload.php');

const DB_HOST = 'eu-cdbr-west-02.cleardb.net';
const DB_USER = 'b1597e3a08d730';
const DB_PASS = '9a13c73f';
const DB_NAME = 'heroku_34fcf0748940255';


function initDB(): MysqliDb{
    $db = new MysqliDb (DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->autoReconnect = true;
    return $db;
}

function getResponse(MysqliDb $db, $request){
    $db->where('request', $request);
    $response = $db->getValue('cach_requests', 'response');
    return json_decode($response, JSON_OBJECT_AS_ARRAY);
}

function insertRow(MysqliDb $db, $id, $request, $response){
    $row = [
        'id' => $id,
        'request' => $request,
        'response' => json_encode($response),
        'date' => new DateTime()
    ];
    $db->insert($db,$row);
}

<?php

require_once('vendor/autoload.php');
require_once('consts.php');

function initDB(): MysqliDb{
    $db = new MysqliDb (DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->autoReconnect = true;
    return $db;
}

function getResponseFromBD(MysqliDb $db, $request){
    $db->where('request', $request);
    $cach_request = $db->get('cach_requests');
    if (!$cach_request) {
        return NULL;
    }
    $date_request = DateTime::createFromFormat('Y-m-d', $cach_request[0]['date']);
    $date_now = new DateTime('now');
    $date_diff = date_diff($date_now, $date_request)->format('%a');
    if ($date_diff == '0') {
        return json_decode($cach_request[0]['response'], true);
    } else {
        return NULL;
    }
}

function insertResponseInDB(MysqliDb $db, $request, $response) {
    $response_row = [
        'request' => $request,
        'response' => json_encode($response),
        'date' => date('Y-m-d')
    ];
    $db->where('request', $request);
    $cach_request = $db->get('cach_requests');
    if ($cach_request) {
        $db->update ('cach_requests', $response_row);
    } else {
        $db->insert('cach_requests', $response_row);
    }
}

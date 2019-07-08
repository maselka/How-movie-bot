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
    $cach_request = $db->get('cach_requests');

    error_log(var_export($cach_request[0], true));

    //$response = $db->getValue('cach_requests', 'response');
    //$date_request = $db->getValue('cach_requests', 'date');

    //$date_request = date_create_from_format('Y.m.d', $date_request);
    //$date_now = new DateTime('now');

    $date_request = DateTime::createFromFormat('Y-m-d', $cach_request[0]['date']);
    $date_now = new DateTime('now');

    $date_diff = date_diff($date_now, $date_request);//->format('%a');
    //$date_diff=$date_request->diff($date_now)->format("%a");
    error_log(var_export($date_request, true));
    error_log(var_export($date_now, true));
    error_log(var_export($date_diff, true));
    if ($date_diff < 1) {
        return json_decode($cach_request['response'], true);
    } else {
        return NULL;
    }
}

function insertRow(MysqliDb $db, $request, $response){
    $row = [
        'request' => $request,
        'response' => json_encode($response),
        'date' => date('Y.m.d')
    ];
    $db->insert('cach_requests', $row);
}

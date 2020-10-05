<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        if($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET' || $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: X-Requested-With, X-authentication,Content-Type, X-client');
        }
    }
    exit;
}
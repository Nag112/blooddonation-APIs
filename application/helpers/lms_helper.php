<?php

function generateRandomNumber($length = 6)
{
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i ++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function send_sms($msg, $mbl)
{
    $msg = urlencode($msg);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://103.247.98.91/API/SendMsg.aspx?uname=20181090&pass=9Q1Jp9oa&send=SKILLL&dest=$mbl&msg=$msg&priority=1");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
}
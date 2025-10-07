<?php

ob_start();
session_start();
date_default_timezone_set("Asia/Calcutta");
$website_name = "Astute Employee";
$ProjectName = "Astute Employee";
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.1.203') {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "astute_emp";
    $web_url = 'http://192.168.1.203/employee/';
    $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ' . mysqli_connect_error());
    $cateperpaging = 50;
} else if ($_SERVER['SERVER_NAME'] == 'getdemo.in' || $_SERVER['SERVER_NAME'] == 'www.getdemo.in') {
    $dbhost = "localhost";
    $dbuser = "getdemo";
    $dbpass = "!PO3aMnuVP&O";
    $dbname = "getdemo_astuteemployee";
    $web_url = 'http://' . $_SERVER['SERVER_NAME'] . '/astuteemployee/';
    $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ' . mysqli_connect_error());
    $cateperpaging = 50;
    $mailHost = "mail.getdemo.in";
    $mailUsername = "info@getdemo.in";
    $mailPassword = "Info@123@1@";
    $mailSMTPSecure = 'tls';
    $mailFrom = "no-replay@getdemo.in";
    $mailFromName = "hero collection";
    $mailAddReplyTo = "no-replay@getdemo.in";
    $adminmail = "mihirparikh93@gmail.com";
} else if ($_SERVER['SERVER_NAME'] == 'astutemanagement.co.in' || $_SERVER['SERVER_NAME'] == 'www.astutemanagement.co.in') {
    $dbhost = "localhost";
    $dbuser = "httpastutemanage";
    $dbpass = "#4XP*Gh8}mWR";
    $dbname = "httpastu_astutecrm";
    $web_url = 'https://' . $_SERVER['SERVER_NAME'] . '/astutecrm/';
    $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ' . mysqli_connect_error());
    $cateperpaging = 50;
//    $mailHost = "mail.astutemanagement.co.in";
//    $mailUsername = "no-reply@astutemanagement.co.in";
//    $mailPassword = "cG7@04BvIb8I";
//    $mailSMTPSecure = 'tls';
//    $mailFrom = "no-reply@astutemanagement.co.in";
//    $mailFromName = "CCPA";
//    $mailAddReplyTo = "no-reply@astutemanagement.co.in";
}else{    
    $dbhost = "localhost";
    $dbuser = "httpastutemanage";
    $dbpass = "#4XP*Gh8}mWR";   
    $dbname = "httpastu_astutecrm"; 
    $web_url = 'https://' . $_SERVER['SERVER_NAME'] . '/astutecrm/';
    $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ' . mysqli_connect_error());
    $cateperpaging = 50;
//    $mailHost = "mail.astutemanagement.co.in";
//    $mailUsername = "no-reply@astutemanagement.co.in";
//    $mailPassword = "cG7@04BvIb8I";
//    $mailSMTPSecure = 'tls';
//    $mailFrom = "no-reply@astutemanagement.co.in";
//    $mailFromName = "CCPA";
//    $mailAddReplyTo = "no-reply@astutemanagement.co.in"; 
} ?> 
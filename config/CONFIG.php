<?php
session_start();

// clound 9용 설정
if  ($_SERVER['REMOTE_ADDR']!="::1")
{
    // 값 변수
    $db_host   = "localhost";
    $db_user   = "lhs0806";
    $db_passwd = "";

    $db_name   = "c9";

    // 경로 변수
    $path_AjaxJSON = "../AjaxJSON" ;
    $path_Root     = "" ;
}

// 로컬용 설정
if  ($_SERVER['REMOTE_ADDR']=="::1")
{
    // 값 변수
    $db_host   = "localhost";
    $db_user   = "root";
    $db_passwd = "l2619097";

    $db_name   = "my_test_db";


    // 경로 변수
    $path_AjaxJSON = "../AjaxJSON" ;
    $path_Root     = "/PhpTest" ;
}
?>
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


    $PhpSelf = $_SERVER['PHP_SELF'];

    //echo $PhpSelf;
    if  ( ($PhpSelf == "/PhpTest/Index.php") || ($PhpSelf == "/PhpTest/index.php") ) // 초기 화면..
    {
        // 초기화면에서 세션이 있으면 MainPages/ 로 이동한다.
        if  ($_SESSION['user_seq'])  Header("Location:MainPages/"); // 이미 로그인 세션이 확보되어 있다면 MainPage쪽으로 간다.....
    }
    /***********************************************************************************
    else
    {
        // 초기화면이 아닌 일반 화면에서 세션이 없다면 초기화면으로 간다.
        if  (!$_SESSION['user_seq'])  Header("Location:/PhpTest/index.php"); // 로그인 세션이 확보되어 있지 않다면..
    }
    ***********************************************************************************/
?>
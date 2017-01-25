<?php
    //echo $_SESSION['user_seq'];
    if  (!$_SESSION['user_seq'])  Header("Location:/PhpTest/index.php"); // 로그인 세션이 확보되어 있지 않다면 메일로그인화면으로 강제이동.....
?>
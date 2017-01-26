<?php
    session_start();

    // 로컬용 설정
    //if  ($_SERVER['REMOTE_ADDR']=="::1")
    if  (($_SERVER["HTTP_HOST"] == "localhost.") || ($_SERVER["HTTP_HOST"] == "localhost") || ($_SERVER["HTTP_HOST"] == "lhs0806.iptime.org"))
    {
        // 값 변수
        $db_host   = "localhost";
        $db_user   = "root";
        $db_passwd = "l2619097";

        $db_name   = "my_test_db";

        // 경로 변수
        $path_AjaxJSON    = "../AjaxJSON" ;
        $path_AjaxSESSION = "../AjaxSESSION" ;
        $path_AjaxLOGMYSQL= "../AjaxLOGMYSQL" ;
        $path_Root        = "/PhpTest" ;
    }
    else
    {
        // 값 변수
        $db_host   = "localhost";
        /*
        $db_user   = "lhs0806";
        $db_passwd = "";

        $db_name   = "c9";
        */
        $db_user   = "cineon";
        $db_passwd = "cineon5421";

        $db_name   = "cineon";

        // 경로 변수
        $path_AjaxJSON    = "../AjaxJSON" ;
        $path_AjaxSESSION = "../AjaxSESSION" ;
        $path_AjaxLOGMYSQL= "../AjaxLOGMYSQL" ;
        $path_Root        = "" ;
    }

    $PhpSelf = $_SERVER['PHP_SELF'];

    /*********************************************************************************************************************
     * 비번 복호화를 위해 사용한다.
     *
     * @param string $hexa 클라이언트에서 넘어오는 비번
     * @return string
     */
    function Hex2String($hexa)
    {
        $return = "";

        for ($i=0; $i < strlen($hexa)-1; $i+=2)
        {
            $return .= chr(hexdec($hexa[$i].$hexa[$i+1]));
        }

        return $return ;
    }

?>
<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    $a_json  = array() ;
    $a_list  = array() ;

    for ($seq=0 ; $seq <= 15 ; $seq++) // 0~15회차
    {
        $name= ($seq==0) ? "특회" : $seq."회" ;
    	array_push($a_list, array( "seq" => "inn".$seq
    	                         , "name" => $name
    	                         )
    	          ) ;
    }

    $a_json = array("result" => "ok", "options" => $a_list,"etcs" => "");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
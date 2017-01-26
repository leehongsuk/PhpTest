<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_AFFILIATE_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $affiliate_nm);

    while ($stmt->fetch())
    {
    	array_push($a_list, array( "optionValue" => $seq
    	                         , "optionText" => $affiliate_nm
    	                         )
    	          ) ;
    }
    $stmt->close();

    $a_json = array("result" => "ok", "options" => $a_list, "etcs" => "");

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
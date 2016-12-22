<?php
require_once("../config/CONFIG.php");

require_once("../config/DB_CONNECT.php");

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL  SP_BAS_CONTACT_SEL()";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($code,$contact_nm);

    while ($stmt->fetch())
    {
    	array_push($a_list, array("optionValue" => $code, "optionText" => $contact_nm)) ;
    }
    $stmt->close();

    $a_json = array("result" => "ok", "options" => $a_list,"etcs" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
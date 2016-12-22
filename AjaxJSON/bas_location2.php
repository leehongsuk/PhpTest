<?php
require_once("../config/CONFIG.php");

require_once("../config/DB_CONNECT.php");

    $post_parent_seq  = $_POST["parent_seq"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL  SP_BAS_LOCATION_SEL_CHILD(?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("i", $post_parent_seq);
    $stmt->execute();

    $stmt->bind_result($seq,$location_nm);

    while ($stmt->fetch())
    {
    	array_push($a_list, array("optionValue" => $seq, "optionText" => $location_nm)) ;
    }
    $stmt->close();

    $a_json = array("result" => "ok", "options" => $a_list,"etcs" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_pageNo       = $_POST["pageNo"] ;
    $post_pageSize     = $_POST["pageSize"] ;

    $a_json  = array() ;


    $query= "CALL SP_LOG_MYSQL_SEL_COUNT()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $a_json = array("count" => $count);

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
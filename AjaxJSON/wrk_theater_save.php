<?php
require_once("../config/CONFIG.php");

require_once("../config/DB_CONNECT.php");


print_r($_REQUEST);
    foreach( $_REQUEST as $key => $val )
    {

        ////echo $key."=".$val."<br>";
    }
    echo $values ;

    /*
    $query= "CALL  SP_BAS_PREMIUM_RATE_UPDATE(?,?,?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("sss",$korabd_gbn,$values,$separator);
    $stmt->execute();
    $stmt->close();
    */


require_once("../config/DB_DISCONNECT.php");
?>
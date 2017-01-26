<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $query= "CALL mylogclear()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->close();


require_once("../config/DB_DISCONNECT.php");
?>
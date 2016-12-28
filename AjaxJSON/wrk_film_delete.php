<?php
require_once("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once("../config/DB_CONNECT.php");

    $post_code = $_POST["code"] ;


    $query= "CALL  SP_WRK_FILM_DELETE(?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("i", $post_code);
    $stmt->execute();
    $stmt->close();

require_once("../config/DB_DISCONNECT.php");
?>
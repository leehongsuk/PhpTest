<?php
require_once("../config/CONFIG.php");

require_once("../config/DB_CONNECT.php");

    $post_a_seq   = $_POST["a_seq"] ;
    $post_id_code = $_POST["id_code"] ;
    $post_ua_seq  = $_POST["ua_seq"] ;
    $post_value   = $_POST["value"] ;


    $query= "CALL  SP_BAS_PREMIUM_RATE_UPDATE(?,?,?,?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("isii",$post_a_seq
                            ,$id_code
                            ,$post_ua_seq
                            ,$post_value
                     );
    $stmt->execute();
    $stmt->close();

require_once("../config/DB_DISCONNECT.php");
?>
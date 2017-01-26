<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_user_id   = $_POST["user_id"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_USR_LOGIN_ID_CHECK(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_user_id);
    $stmt->execute();

    $stmt->bind_result( $count
                      , $del_flag
                      , $delete_dt
                      );


    if ($stmt->fetch())
    {
        $a_json["count_id"]  = $count;
        $a_json["del_flag"]  = $del_flag;
        $a_json["delete_dt"] = $delete_dt;
    }

    $stmt->close();


require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
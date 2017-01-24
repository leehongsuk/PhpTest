<?php
require_once ("../config/CONFIG.php");
require_once ("../config/DB_CONNECT.php");


    $post_theater_code   = $_POST["theater_code"] ;
    $post_showroom_seq   = $_POST["showroom_seq"] ;
    $post_film_code      = $_POST["film_code"] ;
    $post_playprint_seq  = $_POST["playprint_seq"] ;
    $post_change_value   = $_POST["change_value"] ; //  (=='지정') ? 'Y' : 'N'


    $query= "CALL SP_WRK_PLAY_MAST_CREATE(?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "sisis"
                     , $post_theater_code
                     , $post_showroom_seq
                     , $post_film_code
                     , $post_playprint_seq
                     , $post_change_value
                     );
    $stmt->execute();
    $stmt->close();


    // 결과만 반환한다.
    //echo json_encode($output,JSON_UNESCAPED_UNICODE);

require_once ("../config/DB_DISCONNECT.php");
?>
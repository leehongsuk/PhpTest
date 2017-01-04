<?php
require_once("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once("../config/DB_CONNECT.php");

    $post_theater_code = $_POST["theater_code"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_THEATER_SHOWROOM_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_theater_code);
    $stmt->execute();

    $stmt->bind_result($seq,$theater_code,$room_nm,$room_alias,$art_room,$seat);

    while ($stmt->fetch())
    {
        array_push($a_list, array("seq" => $seq
                                  ,"theater_code" => $theater_code
                                  ,"room_nm" => $room_nm
                                  ,"room_alias" => $room_alias
                                  ,"art_room" => $art_room
                                  ,"seat" => $seat
                                  )
                  );
    }
    $stmt->close();

    $a_json = array("result" => "ok", "list" => $a_list, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
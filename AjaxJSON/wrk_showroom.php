<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_code  = $_POST["code"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_THEATER_SHOWROOM_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result($seq,$theater_code,$room_nm,$room_alias,$art_room,$seat,$special_seq,$special_nm,$special_etc,$specail_seet);

    while ($stmt->fetch())
    {
        array_push($a_list, array("seq"          => $seq
                                 ,"theater_code" => $theater_code
                                 ,"room_nm"      => $room_nm
                                 ,"room_alias"   => $room_alias
                                 ,"art_room"     => ($art_room=='Y') ? 'Y' : 'N'
                                 ,"seat"         => $seat
                                 ,"special_seq"  => $special_seq
                                 ,"special_nm"   => $special_nm
                                 ,"special_etc"  => $special_etc
                                 ,"special_seat" => $specail_seet
                               )
                   );
    }
    $stmt->close();

    $a_json = array("result" => "ok", "list" => $a_list, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
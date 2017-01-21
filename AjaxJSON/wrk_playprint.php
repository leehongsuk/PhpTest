<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_code  = $_POST["code"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_FILM_PLAYPRINT_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result( $seq
                      , $film_code
                      , $playprint1_seq
                      , $playprint1
                      , $playprint2_seq
                      , $playprint2
                      , $memo
                      , $cnt_theater
                      , $cnt_showroom
                      );

    while ($stmt->fetch())
    {
        array_push($a_list, array( "seq" => $seq
                                 , "film_code" => $film_code
                                 , "playprint1_seq" => $playprint1_seq
                                 , "playprint1" => $playprint1
                                 , "playprint2_seq" => $playprint2_seq
                                 , "playprint2" => $playprint2
                                 , "memo" => $memo
                                 , "cnt_theater" => $cnt_theater
                                 , "cnt_showroom" => $cnt_showroom
                                 )
                  );
    }
    $stmt->close();

    $a_json = array("result" => "ok", "list" => $a_list, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
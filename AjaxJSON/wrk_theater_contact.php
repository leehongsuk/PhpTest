<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    $post_theater_code = $_POST["theater_code"] ;
    $post_gbn_code     = $_POST["gbn_code"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_THEATER_CONTACT_SEL(?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "ss"
                     , $post_theater_code
                     , $post_gbn_code
                     );
    $stmt->execute();

    $stmt->bind_result( $seq
                      , $theater_code
                      , $name
                      , $tel
                      , $hp
                      , $fax
                      , $mail
                      );

    while ($stmt->fetch())
    {
        array_push($a_list, array( "seq" => $seq
                                 , "theater_code" => $theater_code
                                 , "name" => $name
                                 , "tel" => $tel
                                 , "hp" => $hp
                                 , "fax" => $fax
                                 , "mail" => $mail
                                 )
                  ) ;
    }
    $stmt->close();

    $a_json = array("result" => "ok", "list" => $a_list, "msg" => "");

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
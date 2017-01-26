<?php
if  ($_SESSION['user_seq'])
{
    require_once("../config/CONFIG.php");
    require_once("../config/DB_CONNECT.php");

    $values = "" ;
    $separator = "|" ;

    foreach( $_REQUEST as $key => $val ) // 모든 post요소를 다 뒤집어본다..
    {
        if  ($key == "KorabdGbn") $korabd_gbn = $val ;
        else
        {
            if  (strlen($values) > 0)  $values .= $separator ;

            $values .= ($key."=".$val) ;
        }
    }
    //echo $values ;

    $query= "CALL SP_BAS_PREMIUM_RATE_SAVE(?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "sss"
                     , $korabd_gbn
                     , $values
                     , $separator
                     );
    $stmt->execute();
    $stmt->close();

    $a_json = array("result" => "ok", "msg" => "");

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
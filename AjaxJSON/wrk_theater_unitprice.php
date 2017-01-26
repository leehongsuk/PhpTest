<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    $post_code = $_POST["code"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_THEATER_UNITPRICE_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result( $seq
                      , $unit_price
                      , $unit_price_seq
                      );

    while ($stmt->fetch())
    {
    	array_push($a_list, array( "seq" => $seq
              	                 , "unit_price" => $unit_price
              	                 , "unit_price_seq" => $unit_price_seq
    	                         )
    	          ) ;
    }
    $stmt->close();

    $a_json = array("result" => "ok", "options" => $a_list,"etcs" => "");

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
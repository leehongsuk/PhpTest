<?php
require_once("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once("../config/DB_CONNECT.php");

    $post_theater_code = $_POST["theater_code"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL  SP_WRK_THEATER_DISTRIBUTOR_SEL(?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_theater_code);
    $stmt->execute();

    $stmt->bind_result($theater_code,$distributor_seq,$theater_knm,$theater_enm,$theater_dcode);

    while ($stmt->fetch())
    {
        array_push($a_list, array("theater_code" => $theater_code
                                  ,"distributor_seq" => $distributor_seq
                                  ,"theater_knm" => $theater_knm
                                  ,"theater_enm" => $theater_enm
                                  ,"theater_dcode" => $theater_dcode
                                  )
                  ) ;
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
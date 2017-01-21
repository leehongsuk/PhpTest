<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_pageNo       = $_POST["pageNo"] ;
    $post_pageSize     = $_POST["pageSize"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_LOG_MYSQL_SEL_COUNT()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_LOG_MYSQL_SEL_PAGE(?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "ii"
                     , $post_pageNo
                     , $post_pageSize
                     );
    $stmt->execute();

    $stmt->bind_result( $event_time
                      , $command_type
                      , $argument
                      );


    while ($stmt->fetch())
    {
        array_push($a_list, array( "event_time" => substr($event_time, -8)
                                 , "command_type" => $command_type
                                 , "argument" => $argument
                                 )
                  );
    }


    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

    $stmt->close();

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_pageNo     = $_POST["pageNo"] ;
    $post_pageSize   = $_POST["pageSize"] ;
    $post_film_code  = $_POST["film_code"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_PLAYPRINT_SEL_COUNT(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("i", $post_film_code);
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_WRK_PLAYPRINT_SEL_PAGE(?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("sii", $post_film_code, $post_pageNo, $post_pageSize);
    $stmt->execute();

    $stmt->bind_result($seq,$playprint1,$playprint2,$memo);

    while ($stmt->fetch())
    {
        array_push($a_list, array("seq" => $seq
                                  ,"playprint1" => $playprint1
                                  ,"playprint2" => $playprint2
                                  ,"memo" => $memo
                                  )
                  );
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
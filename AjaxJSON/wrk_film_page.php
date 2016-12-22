<?php
require_once("../config/CONFIG.php");

require_once("../config/DB_CONNECT.php");

    $post_pageNo     = $_POST["pageNo"] ;
    $post_pageSize   = $_POST["pageSize"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL  SP_WRK_FILM_SEL_COUNT()";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL  SP_WRK_FILM_SEL_PAGE(?,?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("ii", $post_pageNo, $post_pageSize);
    $stmt->execute();

    $stmt->bind_result($code,$distributor,$film_nm,$grade,$first_play_dt,$open_dt,$close_dt,$reopem_dt,$reclose_dt,$poster_yn,$images_no,$del_flag);

    while ($stmt->fetch())
    {
        array_push($a_list, array("code" => $code
                                  ,"distributor" => $distributor
                                  ,"film_nm" => $film_nm
                                  ,"grade" => $grade
                                  ,"first_play_dt" => $first_play_dt
                                  ,"open_dt" => $open_dt
                                  ,"close_dt" => $close_dt
                                  ,"reopem_dt" => $reopem_dt
                                  ,"reclose_dt" => $reclose_dt
                                  ,"poster_yn" => $poster_yn
                                  ,"images_no" => $images_no
                                  )
                  );
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
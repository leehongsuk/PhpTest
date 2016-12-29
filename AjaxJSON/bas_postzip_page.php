<?php
require_once("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once("../config/DB_CONNECT.php");

    $post_dongNm   = $_POST["dongNm"] ;
    $post_pageNo   = $_POST["pageNo"] ;
    $post_pageSize = $_POST["pageSize"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_POSTZIP_SEL_COUNT(?)" ; // <-----   
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_dongNm  );
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_BAS_POSTZIP_SEL_PAGE(?,?,?)" ; // <-----   
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("sii", $post_dongNm
                           , $post_pageNo
                           , $post_pageSize
                      );
    $stmt->execute();

    $stmt->bind_result( $code
                       ,$si_do_k
                       ,$si_do_e
                       ,$kun_ku_k
                       ,$kun_ku_e
                       ,$ub_myun_k
                       ,$ub_myun_e
                       ,$road_cd
                       ,$road_nm_k
                       ,$road_nm_e
                       ,$under
                       ,$buildno_bun1
                       ,$buildno_bun2
                       ,$buildno_mng
                       ,$delivery_loc
                       ,$building_nm
                       ,$bjd_cd
                       ,$bjd_nm
                       ,$lee_nm
                       ,$dong_nm
                       ,$mountain
                       ,$jibun1
                       ,$ub_myun_dong_seq
                       ,$jibun2
                      ) ;

    while ($stmt->fetch())
    {
        array_push($a_list, array("code" => $code
                                  ,"address_nm" => $si_do_k." ".$kun_ku_k." ".$dong_nm." ".$road_nm_k
                                  )
                  );
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
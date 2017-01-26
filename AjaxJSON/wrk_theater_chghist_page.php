<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    $post_pageNo       = $_POST["pageNo"] ;
    $post_pageSize     = $_POST["pageSize"] ;
    $post_theater_code = $_POST["theater_code"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_THEATER_CHGHIST_SEL_COUNT(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_theater_code);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_WRK_THEATER_CHGHIST_SEL_PAGE(?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "sii"
                     , $post_theater_code
                     , $post_pageNo
                     , $post_pageSize
                     );
    $stmt->execute();

    $stmt->bind_result( $seq
                      , $gubun
                      , $theater_code
                      , $change_date
                      , $change_time
                      , $loc1
                      , $loc2
                      , $affiliate_seq
                      , $dir_mng
                      , $unaffiliate
                      , $user_group
                      , $theater_nnm
                      , $fund_free
                      , $gubun_code
                      , $saup_no
                      , $owner
                      , $sangho
                      , $homepage
                      , $images_no
                      , $del_dt
                      ); // 20

    while ($stmt->fetch())
    {
        array_push($a_list, array( "seq" => $seq
                                 , "gubun" => $gubun
                                 , "theater_code" => $theater_code
                                 , "change_datetime" => $change_date ." ".  $change_time
                                 , "location" => $loc1 ." ". $loc2
                                 , "affiliate_seq" => $affiliate_seq
                                 , "dir_mng" => $dir_mng
                                 , "unaffiliate" => $unaffiliate
                                 , "user_group" => $user_group
                                 , "del_dt" => $del_dt
                                 , "theater_nnm" => $theater_nnm
                                 , "fund_free" => $fund_free
                                 , "gubun_code" => $gubun_code
                                 , "saup_no" => $saup_no
                                 , "owner" => $owner
                                 , "sangho" => $sangho
                                 , "homepage" => $homepage
                                 , "images_no" => $images_no
                                 )
                  );
     }


    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

    $stmt->close();

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
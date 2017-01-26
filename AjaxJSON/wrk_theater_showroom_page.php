<?php
if  ($_SESSION['user_seq'])
{
    require_once("../config/CONFIG.php");
    require_once("../config/DB_CONNECT.php");

    $post_location1    = $_POST["location1"] ;
    $post_location2    = $_POST["location2"] ;
    $post_affiliate    = $_POST["affiliate"] ;
    $post_unaffiliate  = $_POST["unaffiliate"] ;
    $post_theaterNm    = $_POST["theaterNm"] ;
    $post_onlylive     = $_POST["onlylive"] ;
    $post_fundFree     = $_POST["fundFree"] ;
    $post_pageNo       = $_POST["pageNo"] ;
    $post_pageSize     = $_POST["pageSize"] ;

    $post_filmcode     = $_POST["filmCode"] ; // 8
    $post_playprintseq = $_POST["playprintSeq"] ;
    $post_mappinged    = ($_POST["mappinged"]=="Y")?"Y":"N" ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_THEATER_SHOWROOM_SEL_COUNT(?,?,?,?,?,?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "iiiissssis"
                     , $post_location1
                     , $post_location2
                     , $post_affiliate
                     , $post_unaffiliate
                     , $post_theaterNm
                     , $post_onlylive
                     , $post_fundFree
                     , $post_filmcode
                     , $post_playprintseq
                     , $post_mappinged
                     );
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_WRK_THEATER_SHOWROOM_SEL_PAGE(?,?,?,?,?,?,?,?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "iiiissssisii"
                     , $post_location1
                     , $post_location2
                     , $post_affiliate
                     , $post_unaffiliate
                     , $post_theaterNm
                     , $post_onlylive
                     , $post_fundFree
                     , $post_filmcode
                     , $post_playprintseq
                     , $post_mappinged
                     , $post_pageNo
                     , $post_pageSize
                     );
    $stmt->execute();

    $stmt->bind_result( $code
                      , $loc1
                      , $loc2
                      , $affiliate_nm
                      , $direct_nm
                      , $unaffiliate_nm
                      , $user_group_nm
                      , $theater_nm
                      , $room_seq
                      , $room_nm
                      , $room_alias
                      , $mapping_dt
                      , $unmapping_dt
                      ) ;

    while ($stmt->fetch())
    {
        array_push($a_list, array( "code" => $code
                                 , "room_seq" => $room_seq
                                 , "location" => $loc1 ." ". $loc2
                                 , "affiliate_nm" => $affiliate_nm
                                 , "direct_nm" => $direct_nm
                                 , "unaffiliate_nm" => $unaffiliate_nm
                                 , "user_group_nm" => $user_group_nm
                                 , "theater_nm" => $theater_nm
                                 , "showroom_nm" => $room_nm ."(". $room_alias .")"
                                 , "mapping_dt" => $mapping_dt
                                 , "unmapping_dt" => $unmapping_dt
                                 )
                  );
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
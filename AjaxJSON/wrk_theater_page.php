<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_location1   = $_POST["location1"] ;
    $post_location2   = $_POST["location2"] ;
    $post_affiliate   = $_POST["affiliate"] ;
    $post_isdirect    = $_POST["isdirect"] ;
    $post_unaffiliate = $_POST["unaffiliate"] ;
    $post_usergroup   = $_POST["usergroup"] ;
    $post_theaterNm   = $_POST["theaterNm"] ;
    $post_operation   = $_POST["operation"] ;
    $post_fundFree    = $_POST["fundFree"] ;
    $post_pageNo      = $_POST["pageNo"] ;
    $post_pageSize    = $_POST["pageSize"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_THEATER_SEL_COUNT(?,?,?,?,?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "iiisiisss"
                     , $post_location1
                     , $post_location2
                     , $post_affiliate
                     , $post_isdirect
                     , $post_unaffiliate
                     , $post_usergroup
                     , $post_theaterNm
                     , $post_operation
                     , $post_fundFree
                     );
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_WRK_THEATER_SEL_PAGE(?,?,?,?,?,?,?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "iiisiisssii"
                     , $post_location1
                     , $post_location2
                     , $post_affiliate
                     , $post_isdirect
                     , $post_unaffiliate
                     , $post_usergroup
                     , $post_theaterNm
                     , $post_operation
                     , $post_fundFree
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
                      , $open_dt
                      , $post_operation
                      , $theater_nm
                      , $zip
                      , $addr1
                      , $addr2
                      , $score_tel
                      , $score_fax
                      , $score_mail
                      , $score_sms
                      , $premium_tel
                      , $premium_fax
                      , $premium_mail
                      , $premium_sms
                      , $fund_free
                      , $gubun_code
                      , $saup_no
                      , $owner
                      , $sangho
                      , $homepage
                      , $images_no
                      , $cnt_showroom
                      ) ;

    while ($stmt->fetch())
    {
        array_push($a_list, array( "code" => $code
                                 , "location" => $loc1
                                 , "affiliate_nm" => $affiliate_nm
                                 , "direct_nm" => $direct_nm
                                 , "unaffiliate_nm" => $unaffiliate_nm
                                 , "user_group_nm" => $user_group_nm
                                 , "open_dt" => $open_dt
                                 , "operation" => $post_operation
                                 , "theater_nm" => $theater_nm
                                 , "zip" => $zip
                                 , "address" => $addr1
                                 , "score_tel" => $score_tel
                                 , "score_fax" => $score_fax
                                 , "score_mail" => $score_mail
                                 , "score_sms" => $score_sms
                                 , "premium_tel" => $premium_tel
                                 , "premium_fax" => $premium_fax
                                 , "premium_mail" => $premium_mail
                                 , "premium_sms" => $premium_sms
                                 , "meno" => $meno
                                 , "fund_free" => $fund_free
                                 , "gubun_code" => $gubun_code
                                 , "saup_no" => $saup_no
                                 , "owner" => $owner
                                 , "sangho" => $sangho
                                 , "homepage" => $homepage
                                 , "images_no" => $images_no
                                 , "cnt_showroom" => $cnt_showroom
                                 )
                  );
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
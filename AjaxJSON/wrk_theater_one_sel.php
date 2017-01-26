<?php
if  ($_SESSION['user_seq'])
{
    require_once("../config/CONFIG.php");
    require_once("../config/DB_CONNECT.php");

    $post_mode = $_POST["mode"] ;
    $post_code = $_POST["code"] ;

    $a_json         = array() ;
    $a_contacts     = array() ;
    $a_showrooms    = array() ;
    $a_distributors = array() ;


    // 연락처 구분 리스트 (탭에 사용)..
    $a_contact_option  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_CONTACT_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($code, $contact_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $code
                                 , "optionText" => $contact_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_contact_option = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 연락처 구분 리스트 (탭에 사용)..



    // 상위 지역 리스트를 구한다. .......
    $a_loc1_option  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_LOCATION_SEL_PARENT()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $location_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $location_nm
                                 )
                  ) ;

    }
    $stmt->close();

    $a_loc1_option = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 상위 지역 리스트를 구한다. .......



    // 계열사 리스트를 구한다. .......
    $a_affiliate_option  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_AFFILIATE_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $affiliate_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $affiliate_nm
                                 )
                  ) ;

    }
    $stmt->close();

    $a_affiliate_option = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 계열사 리스트를 구한다. .......




    // 직영/위탁 리스트를 구한다....
    $a_isdirect_option  = array() ;
    $a_list             = array() ;


    $query= "CALL SP_BAS_ISDIRECT_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($code, $direct_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $code
                                 , "optionText" => $direct_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_isdirect_option = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 직영/위탁 리스트를 구한다....



    // 비계열사 리스트를 구한다. .......
    $a_unaffiliate_option  = array() ;
    $a_list                = array() ;


    $query= "CALL SP_BAS_UNAFFILIATE_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $unaffiliate_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $unaffiliate_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_unaffiliate_option = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 비계열사 리스트를 구한다. .......

    // 사용자그룹 리스트를 구한다. ......
    $a_usergroup_option  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_USER_GROUP_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $user_group_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $user_group_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_usergroup_option = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 사용자그룹 리스트를 구한다. ......


    // 요금체제 리스트를 구한다. ......
    $post_code = $_POST["code"] ;

    $a_unitprices  = array() ;
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

    $a_unitprices = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 요금체제 리스트를 구한다. ......


    // 특별좌석 기초자료 리스트
    $a_spcial_seat  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_SPCIAL_SEAT_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $special_seat_nm);

    array_push($a_list, array( "optionValue" => -1
                             , "optionText" => "없음"
                             )
              ) ;

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $special_seat_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_spcial_seat = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 특별좌석 기초자료 리스트

    // 배급사 기초자료 리스트
    $a_distributor  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_DISTRIBUTOR_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $distributor_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $distributor_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_distributor = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 배급사 기초자료 리스트






    if  ($post_mode=="EDIT")
    {
        $query= "CALL SP_BAS_CONTACT_SEL()" ; // <-----
        $stmt = $mysqli->prepare($query);
        $stmt->execute();

        $stmt->bind_result($code, $contact_nm);

        while ($stmt->fetch())
        {
            array_push($a_contacts, array( "code" => $code
                                         , "contact_nm" => $contact_nm
                                         )
                      ) ;
        }
        $stmt->close();

        $arrlength=count($a_contacts);

        for($x=0;$x<$arrlength;$x++)
        {
             $contactGbn = $a_contacts[$x]["code"] ; // 연락처구분 코드.,

             $query= "CALL SP_WRK_THEATER_CONTACT_SEL(?,?)" ; // <-----
             $stmt = $mysqli->prepare($query);

             $stmt->bind_param( "ss"
                              , $post_code
                              , $contactGbn
                              );
             $stmt->execute();

             $stmt->bind_result( $seq
                               , $theater_code
                               , $name
                               , $tel
                               , $hp
                               , $fax
                               , $mail
                               );

             $a_temp = array() ;

             while ($stmt->fetch())
             {
                 array_push($a_temp, array("seq"           => $seq
                                           ,"theater_code" => $theater_code
                                           ,"name"         => $name
                                           ,"tel"          => $tel
                                           ,"hp"           => $hp
                                           ,"fax"          => $fax
                                           ,"mail"         => $mail
                                         )
                           ) ;
             }
             $stmt->close();

             $a_contacts[$x]["contacts"] = $a_temp ;
        }

        $query= "CALL SP_WRK_THEATER_SHOWROOM_SEL(?)" ; // <-----
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $post_code);
        $stmt->execute();

        $stmt->bind_result( $seq
                          , $theater_code
                          , $room_nm
                          , $room_alias
                          , $art_room
                          , $seat
                          , $special_seq
                          , $special_nm
                          , $special_etc
                          , $specail_seet
                          );

        while ($stmt->fetch())
        {
            array_push($a_showrooms, array("seq"           => $seq
                                          ,"theater_code" => $theater_code
                                          ,"room_nm"      => $room_nm
                                          ,"room_alias"   => $room_alias
                                          ,"art_room"     => ($art_room=='Y') ? 'Y' : 'N'
                                          ,"seat"         => $seat
                                          ,"special_seq"  => $special_seq
                                          ,"special_nm"   => $special_nm
                                          ,"special_etc"  => $special_etc
                                          ,"special_seat" => $specail_seet
                                          )
                      );
        }
        $stmt->close();


        $query= "CALL SP_WRK_THEATER_DISTRIBUTOR_SEL(?)" ; // <-----
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $post_code);
        $stmt->execute();

        $stmt->bind_result( $seq
                          , $theater_code
                          , $distributor_seq
                          , $distributor_nm
                          , $theater_knm
                          , $theater_enm
                          , $theater_dcode
                          );

        while ($stmt->fetch())
        {
            array_push($a_distributors, array("seq"              => $seq
                                             ,"theater_code"    => $theater_code
                                             ,"distributor_seq" => $distributor_seq
                                             ,"distributor_nm"  => $distributor_nm
                                             ,"theater_knm"     => $theater_knm
                                             ,"theater_enm"     => $theater_enm
                                             ,"theater_dcode"   => $theater_dcode
                                             )
                      ) ;
        }
        $stmt->close();


        $query= "CALL SP_WRK_THEATER_SEL_ONE(?)" ; // <-----
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $post_code);
        $stmt->execute();

        $stmt->bind_result( $code
                          , $loc1
                          , $loc2
                          , $affiliate_seq
                          , $isdirect
                          , $unaffiliate_seq
                          , $user_group_seq
                          , $open_dt
                          , $del_dt
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
                          , $memo
                          , $fund_free
                          , $gubun_code
                          , $saup_no
                          , $owner
                          , $sangho
                          , $homepage
                          , $images_no
                          ); // 29

        if ($stmt->fetch())
        {
            $a_json = array( "code"             => $code
                           , "loc1"             => $loc1
                           , "loc2"             => $loc2
                           , "affiliate_seq"    => $affiliate_seq
                           , "isdirect"         => $isdirect
                           , "unaffiliate_seq"  => $unaffiliate_seq
                           , "user_group_seq"   => $user_group_seq
                           , "open_dt"          => $open_dt
                           , "del_dt"           => $del_dt
                           , "theater_nm"       => $theater_nm
                           , "zip"              => $zip
                           , "addr1"            => $addr1
                           , "addr2"            => $addr2
                           , "score_tel"        => $score_tel
                           , "score_fax"        => $score_fax
                           , "score_mail"       => $score_mail
                           , "score_sms"        => $score_sms
                           , "premium_tel"      => $premium_tel
                           , "premium_fax"      => $premium_fax
                           , "premium_mail"     => $premium_mail
                           , "premium_sms"      => $premium_sms
                           , "memo"             => $memo
                           , "fund_free"        => $fund_free
                           , "gubun_code"       => $gubun_code
                           , "saup_no"          => $saup_no
                           , "owner"            => $owner
                           , "sangho"           => $sangho
                           , "homepage"         => $homepage
                           , "images_no"        => $images_no
                           ////////////////////
                           , "contacts"         => $a_contacts
                           , "showrooms"        => $a_showrooms
                           , "distributors"     => $a_distributors
                           , "contact_option"   => $a_contact_option
                           , "loc1_option"      => $a_loc1_option
                           , "loc2_option"      => null
                           , "affiliate_option" => $a_affiliate_option
                           , "isdirect_option"  => $a_isdirect_option
                           , "unaffiliate_option" => $a_unaffiliate_option
                           , "usergroup_option" => $a_usergroup_option
                           , "unitprices"       => $a_unitprices
                           , "spcial_seat"      => $a_spcial_seat
                           , "distributor"      => $a_distributor
                           );
        }
        $stmt->close();

        // log2 하위 지역리스트를 구한다.
        $a_loc2_option  = array() ;
        $a_list         = array() ;

        $query= "CALL SP_BAS_LOCATION_SEL_CHILD(?)" ; // <-----
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("i", $loc1);
        $stmt->execute();

        $stmt->bind_result($seq, $location_nm);

        while ($stmt->fetch())
        {
            array_push($a_list, array( "optionValue" => $seq
                                     , "optionText" => $location_nm
                                     )
                      ) ;
        }
        $stmt->close();

        $a_loc2_option = array("result" => "ok", "options" => $a_list,"etcs" => "");

        $a_json["loc2_option"] = $a_loc2_option;
    }

    if  ($post_mode=="APPEND")
    {
         $a_loc2_option  = array() ;

         $a_json = array( "code"             => ""
                        , "loc1"             => $loc1
                        , "loc2"             => $loc2
                        , "affiliate_seq"    => $affiliate_seq
                        , "isdirect"         => $isdirect
                        , "unaffiliate_seq"  => $unaffiliate_seq
                        , "user_group_seq"   => $user_group_seq
                        , "open_dt"          => $open_dt
                        , "del_dt"           => $del_dt
                        , "theater_nm"       => $theater_nm
                        , "zip"              => $zip
                        , "addr1"            => $addr1
                        , "addr2"            => $addr2
                        , "score_tel"        => $score_tel
                        , "score_fax"        => $score_fax
                        , "score_mail"       => $score_mail
                        , "score_sms"        => $score_sms
                        , "premium_tel"      => $premium_tel
                        , "premium_fax"      => $premium_fax
                        , "premium_mail"     => $premium_mail
                        , "premium_sms"      => $premium_sms
                        , "memo"             => ""
                        , "fund_free"        => $fund_free
                        , "gubun_code"       => $gubun_code
                        , "saup_no"          => $saup_no
                        , "owner"            => $owner
                        , "sangho"           => $sangho
                        , "homepage"         => $homepage
                        , "images_no"        => $images_no
                        ////////////////////
                        , "contacts"         => $a_contacts
                        , "showrooms"        => $a_showrooms
                        , "distributors"     => $a_distributors
                        , "contact_option"   => $a_contact_option
                        , "loc1_option"      => $a_loc1_option
                        , "loc2_option"      => $a_loc2_option
                        , "affiliate_option" => $a_affiliate_option
                        , "isdirect_option"  => $a_isdirect_option
                        , "unaffiliate_option" => $a_unaffiliate_option
                        , "usergroup_option" => $a_usergroup_option
                        , "unitprices"       => $a_unitprices
                        , "spcial_seat"      => $a_spcial_seat
                        , "distributor"      => $a_distributor
                        );
    }

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
<?php
require_once("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once("../config/DB_CONNECT.php");

    $post_code = $_POST["code"] ;

    $a_json        = array() ;
    $a_contact     = array() ;
    $a_showroom    = array() ;
    $a_distributor = array() ;


    $query= "CALL SP_BAS_CONTACT_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($code,$contact_nm);

    while ($stmt->fetch())
    {
        array_push($a_contact, array("code" => $code, "contact_nm" => $contact_nm)) ;
    }
    $stmt->close();

    $arrlength=count($a_contact);

    for($x=0;$x<$arrlength;$x++)
    {
         $contactGbn = $a_contact[$x]["code"] ; // 연락처구분 코드.,

         $query= "CALL SP_WRK_THEATER_CONTACT_SEL(?,?)" ; // <-----
         $stmt = $mysqli->prepare($query);

         $stmt->bind_param("ss", $post_code, $contactGbn);
         $stmt->execute();

         $stmt->bind_result($seq,$theater_code,$name,$tel,$hp,$fax,$mail);

         $a_temp = array() ;

         while ($stmt->fetch())
         {
             array_push($a_temp, array("seq" => $seq
                                       ,"theater_code" => $theater_code
                                       ,"name" => $name
                                       ,"tel" => $tel
                                       ,"hp" => $hp
                                       ,"fax" => $fax
                                       ,"mail" => $mail
                                     )
                       ) ;
         }
         $stmt->close();

         $a_contact[$x]["contacts"] = $a_temp ;
    }

    $query= "CALL SP_WRK_THEATER_SHOWROOM_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result($seq,$theater_code,$room_nm,$room_alias,$art_room,$seat);

    while ($stmt->fetch())
    {
        array_push($a_showroom, array("seq" => $seq
                                      ,"theater_code" => $theater_code
                                      ,"room_nm" => $room_nm
                                      ,"room_alias" => $room_alias
                                      ,"art_room" => $art_room
                                      ,"seat" => $seat
                                      )
                  );
    }
    $stmt->close();


    $query= "CALL SP_WRK_THEATER_DISTRIBUTOR_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result($seq,$theater_code,$distributor_seq,$distributor_nm,$theater_knm,$theater_enm,$theater_dcode);

    while ($stmt->fetch())
    {
        array_push($a_distributor, array("seq" => $seq
                                         ,"theater_code" => $theater_code
                                         ,"distributor_seq" => $distributor_seq
                                         ,"distributor_nm" => $distributor_nm
                                         ,"theater_knm" => $theater_knm
                                         ,"theater_enm" => $theater_enm
                                         ,"theater_dcode" => $theater_dcode
                                         )
                  ) ;
    }
    $stmt->close();


    $query= "CALL SP_WRK_THEATER_SEL_ONE(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result($code
                       ,$loc1
                       ,$loc2
                       ,$affiliate_seq
                       ,$isdirect
                       ,$unaffiliate_seq
                       ,$user_group_seq
                       ,$open_dt
                       ,$operation
                       ,$theater_nm
                       ,$zip
                       ,$addr1
                       ,$addr2
                       ,$score_tel
                       ,$score_fax
                       ,$score_mail
                       ,$score_sms
                       ,$premium_tel
                       ,$premium_fax
                       ,$premium_mail
                       ,$premium_sms
                       ,$memo
                       ,$fund_free
                       ,$gubun_code
                       ,$saup_no
                       ,$owner
                       ,$sangho
                       ,$homepage
                       ,$images_no
                       );

    if ($stmt->fetch())
    {
        $a_json = array("code" => $code
                        ,"loc1" => $loc1
                        ,"loc2" => $loc2
                        ,"affiliate_seq" => $affiliate_seq
                        ,"isdirect" => $isdirect
                        ,"unaffiliate_seq" => $unaffiliate_seq
                        ,"user_group_seq" => $user_group_seq
                        ,"open_dt" => $open_dt
                        ,"operation" => $operation
                        ,"theater_nm" => $theater_nm
                        ,"zip" => $zip
                        ,"addr1" => $addr1
                        ,"addr2" => $addr2
                        ,"score_tel" => $score_tel
                        ,"score_fax" => $score_fax
                        ,"score_mail" => $score_mail
                        ,"score_sms" => $score_sms
                        ,"premium_tel" => $premium_tel
                        ,"premium_fax" => $premium_fax
                        ,"premium_mail" => $premium_mail
                        ,"premium_sms" => $premium_sms
                        ,"memo" => $memo
                        ,"fund_free" => $fund_free
                        ,"gubun_code" => $gubun_code
                        ,"saup_no" => $saup_no
                        ,"owner" => $owner
                        ,"sangho" => $sangho
                        ,"homepage" => $homepage
                        ,"images_no" => $images_no
                        ///////////////////////////////
                        ,"contacts" => $a_contact
                        ,"showroom" => $a_showroom
                        ,"distributor" => $a_distributor
                        );
    }
    $stmt->close();



require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
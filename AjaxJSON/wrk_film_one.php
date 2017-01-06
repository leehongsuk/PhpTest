<?php
require_once("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once("../config/DB_CONNECT.php");

    $post_code = $_POST["code"] ;

    $a_json        = array() ;
    $a_contact     = array() ;
    $a_showroom    = array() ;
    $a_distributor = array() ;

    /*
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
     * **/


    $query= "CALL SP_WRK_FILM_SEL_ONE(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result($code
                      ,$distributor_seq
                      ,$distributor_cd
                      ,$film_nm
                      ,$grade
                      ,$first_play_dt
                      ,$open_dt
                      ,$close_dt
                      ,$reopem_dt
                      ,$reclose_dt
                      ,$poster_yn
                      ,$images_no
                      ,$korabd
                      ,$del_flag
                      );

    if ($stmt->fetch())
    {
        $a_json = array("code" => $code
                        ,"distributor_seq" => $distributor_seq
                        ,"distributor_cd" => $distributor_cd
                        ,"film_nm" => $film_nm
                        ,"grade" => $grade
                        ,"first_play_dt" => $first_play_dt
                        ,"open_dt" => $open_dt
                        ,"close_dt" => $close_dt
                        ,"reopem_dt" => $reopem_dt
                        ,"reclose_dt" => $reclose_dt
                        ,"poster_yn" => $poster_yn
                        ,"images_no" => $images_no
                        ,"korabd" => $korabd
                        ,"del_flag" => $del_flag
                        ///////////////////////////////
                        //,"contacts" => $a_contact
                        //,"showroom" => $a_showroom
                        //,"distributor" => $a_distributor
                        );
    }
    $stmt->close();



require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
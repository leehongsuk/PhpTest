<?php
require_once ("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once ("../config/DB_CONNECT.php");

    //    print_r ( $_REQUEST );
    /*
        foreach ( $_REQUEST as $key => $val )
        {
            echo $key."=".$val."<br>";
        }
    print_r( $_POST["contacts"] );
    print_r( $_POST["showroom"] );
    print_r( $_POST["distributor"] );
     * */

    $post_code             = $_POST["code"] ;
    $post_loc1             = $_POST["loc1"] ;
    $post_loc2             = $_POST["loc2"] ;
    $post_affiliate_seq    = $_POST["affiliate_seq"] ;
    $post_isdirect         = $_POST["isdirect"] ;
    $post_unaffiliate_seq  = $_POST["unaffiliate_seq"] ;
    $post_user_group_seq   = $_POST["user_group_seq"] ;
    $post_open_dt          = $_POST["open_dt"] ;
    $post_theater_nm       = $_POST["theater_nm"] ;
    $post_zip              = $_POST["zip"] ;
    $post_addr1            = $_POST["addr1"] ;
    $post_addr2            = $_POST["addr2"] ;
    $post_score_tel        = ($_POST["score_tel"]=="Y")?"Y":"N" ;
    $post_score_fax        = ($_POST["score_fax"]=="Y")?"Y":"N" ;
    $post_score_mail       = ($_POST["score_mail"]=="Y")?"Y":"N" ;
    $post_score_sms        = ($_POST["score_sms"]=="Y")?"Y":"N" ;
    $post_premium_tel      = ($_POST["premium_tel"]=="Y")?"Y":"N" ;
    $post_premium_fax      = ($_POST["premium_fax"]=="Y")?"Y":"N" ;
    $post_premium_mail     = ($_POST["premium_mail"]=="Y")?"Y":"N" ;
    $post_premium_sms      = ($_POST["premium_sms"]=="Y")?"Y":"N" ;
    $post_memo             = $_POST["memo"] ;
    $post_fund_free        = ($_POST["fund_free"]=="Y")?"Y":"N" ;
    $post_gubun_code       = $_POST["gubun_code"] ;
    $post_saup_no          = $_POST["saup_no"] ;
    $post_owner            = $_POST["owner"] ;
    $post_sangho           = $_POST["sangho"] ;
    $post_homepage         = $_POST["homepage"] ;
    $post_images_no        = $_POST["images_no"] ;

    $post_contacts         = $_POST["contacts"] ; // 연락처 JSON
    $post_showrooms        = $_POST["showrooms"] ; // 상영관 JSON
    $post_distributors     = $_POST["distributors"] ; // 배급사 JSON

    if  (isset($_POST["unitPrices"]))  $post_unitPrices = implode(",", $_POST["unitPrices"]) ; // 요금단가..


    $query= "CALL SP_WRK_THEATER_SAVE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@newCode,@output)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "siiisiissssssssssssssssssssis"
                     , $post_code
                     , $post_loc1
                     , $post_loc2
                     , $post_affiliate_seq
                     , $post_isdirect
                     , $post_unaffiliate_seq
                     , $post_user_group_seq
                     , $post_open_dt
                     , $post_theater_nm
                     , $post_zip
                     , $post_addr1
                     , $post_addr2
                     , $post_score_tel
                     , $post_score_fax
                     , $post_score_mail
                     , $post_score_sms
                     , $post_premium_tel
                     , $post_premium_fax
                     , $post_premium_mail
                     , $post_premium_sms
                     , $post_memo
                     , $post_fund_free
                     , $post_gubun_code
                     , $post_saup_no
                     , $post_owner
                     , $post_sangho
                     , $post_homepage
                     , $post_images_no
                     , $post_unitPrices
                     );
    $stmt->execute();

    //echo $stmt->mysql_errno . ": " . $stmt->mysql_error;

    $stmt->close();

    $result = $mysqli->query('SELECT @newCode,@output');
    list($newCode,$output) = $result->fetch_row();

    $theater_code = ($newCode!="") ? $newCode : $post_code ;


    // 연락처(S,P,T)를 받아온다.
    $contacts = json_decode($post_contacts);

    foreach ($contacts as $key1 => $value2)
    {
        $gbn_code = $contacts[$key1]->code ; // S,P,T

        foreach ($contacts[$key1]->contacts as $key2 => $value2)
        {
            $_CUD         = $contacts[$key1]->contacts[$key2]->_CUD ;
            $seq          = $contacts[$key1]->contacts[$key2]->seq ;
            //$theater_code = $contacts[$key1]->contacts[$key2]->theater_code ;
            $name         = $contacts[$key1]->contacts[$key2]->name ;
            $tel          = $contacts[$key1]->contacts[$key2]->tel ;
            $hp           = $contacts[$key1]->contacts[$key2]->hp ;
            $fax          = $contacts[$key1]->contacts[$key2]->fax ;
            $mail         = $contacts[$key1]->contacts[$key2]->mail ;

            //print_r ( $contacts[$key1]->contacts[$key2] );
            //print_r ( $_CUD ." : ".$gbn_code." | ".$seq ." | ".$theater_code  ." | ".$name  ." | ".$tel   ." | ".$hp    ." | ".$fax   ." | ".$mail ."--");
            //print_r ( "\n" );

            if  ($_CUD != "")
            {
                $query= "CALL SP_WRK_THEATER_CONTACT_SAVE(?,?,?,?,?,?,?,?,?)" ; // <-----
                $stmt = $mysqli->prepare($query);

                $stmt->bind_param( "sisssssss"
                                 , $_CUD
                                 , $seq
                                 , $theater_code
                                 , $gbn_code
                                 , $name
                                 , $tel
                                 , $hp
                                 , $fax
                                 , $mail
                                 );
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // 상영관을 받아온다.
    $contacts = json_decode($post_showrooms);

    foreach ($contacts as $key => $value)
    {
        $_CUD          = $contacts[$key]->_CUD ;
        $seq           = $contacts[$key]->seq ;
        //$theater_code  = $contacts[$key]->theater_code ;
        $room_nm       = $contacts[$key]->room_nm ;
        $room_alias    = $contacts[$key]->room_alias ;
        $art_room      = ($contacts[$key]->art_room=='Y') ? 'Y' : 'N' ;
        $seat          = $contacts[$key]->seat ;
        $special_seq   = $contacts[$key]->special_seq ;
        $special_etc   = $contacts[$key]->special_etc ;
        $special_seat  = $contacts[$key]->special_seat ;


        //print_r ( $contacts[$key] );
        //print_r ( $_CUD ." : ".$seq." | ".$theater_code." | ".$room_nm." | ".$room_alias." | ".$art_room." | ".$seat." | " );
        //print_r ( "\n" );

        if  ($special_seq == -1) // '없음'을 선택하면..
        {
            $special_etc   = "";
            $special_seat  = -1;
        }

        if  ($_CUD != "")
        {
            $query= "CALL SP_WRK_THEATER_SHOWROOM_SAVE(?,?,?,?,?,?,?,?,?,?)" ; // <-----
            $stmt = $mysqli->prepare($query);

            $stmt->bind_param( "sissssiisi"
                             , $_CUD
                             , $seq
                             , $theater_code
                             , $room_nm
                             , $room_alias
                             , $art_room
                             , $seat
                             , $special_seq
                             , $special_etc
                             , $special_seat
                             );
            $stmt->execute();
            $stmt->close();
        }
    }

    // 배급사를 받아온다.
    $contacts = json_decode($post_distributors);

    foreach ($contacts as $key => $value)
    {
        $_CUD             = $contacts[$key]->_CUD ;
        $seq              = $contacts[$key]->seq ;
        //$theater_code     = $contacts[$key]->theater_code ;
        $distributor_seq  = $contacts[$key]->distributor_seq ;
        $theater_knm      = $contacts[$key]->theater_knm ;
        $theater_enm      = $contacts[$key]->theater_enm ;
        $theater_dcode    = $contacts[$key]->theater_dcode ;

        //print_r ( $contacts[$key] );
        //print_r ( $_CUD ." : ".$seq." | ".$theater_code." | ".$distributor_seq." | ".$theater_knm." | ".$theater_enm." | ".$theater_dcode." | " );
        //print_r ( "\n" );

        if  ($_CUD != "")
        {
            $query= "CALL SP_WRK_THEATER_DISTRIBUTOR_SAVE(?,?,?,?,?,?,?)" ; // <-----
            $stmt = $mysqli->prepare($query);

            $stmt->bind_param( "sisisss"
                             , $_CUD
                             , $seq
                             , $theater_code
                             , $distributor_seq
                             , $theater_knm
                             , $theater_enm
                             , $theater_dcode
                             );
            $stmt->execute();
            $stmt->close();
        }
    }

    require_once ("../config/DB_DISCONNECT.php");

    // 결과만 반환한다.
    if  ($output==1)  $a_json = array("result" => "ok",  "output" => $output, "msg" => "저장이 완료되었습니다.");
    else              $a_json = array("result" => "err", "output" => $output, "msg" => "저장 중 오류가 발생하였습니다.");
}
else
{
     $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");

}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
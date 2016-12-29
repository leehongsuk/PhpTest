<?php
require_once ("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once ("../config/DB_CONNECT.php");

    //print_r ( $_REQUEST );

/*
    foreach ( $_REQUEST as $key => $val )
    {
        echo $key."=".$val."<br>";
    }
    print_r( $_POST["unitPrices"] );
 * */


    //$post_OPERATION        = $_POST["OPERATION"] ;
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
    $post_unitPrices       = $_POST["unitPrices"] ;


    $query= "CALL SP_WRK_THEATER_SAVE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@output)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("siiisiissssssssssssssssssssi"
                     ,$post_code
                     ,$post_loc1
                     ,$post_loc2
                     ,$post_affiliate_seq
                     ,$post_isdirect
                     ,$post_unaffiliate_seq
                     ,$post_user_group_seq
                     ,$post_open_dt
                     ,$post_theater_nm
                     ,$post_zip
                     ,$post_addr1
                     ,$post_addr2
                     ,$post_score_tel
                     ,$post_score_fax
                     ,$post_score_mail
                     ,$post_score_sms
                     ,$post_premium_tel
                     ,$post_premium_fax
                     ,$post_premium_mail
                     ,$post_premium_sms
                     ,$post_memo
                     ,$post_fund_free
                     ,$post_gubun_code
                     ,$post_saup_no
                     ,$post_owner
                     ,$post_sangho
                     ,$post_homepage
                     ,$post_images_no
                     );
    $stmt->execute();

    //echo $stmt->mysql_errno . ": " . $stmt->mysql_error;

    $stmt->close();

    $result = $mysqli->query('SELECT @output');
    list($output) = $result->fetch_row();

    echo json_encode($output,JSON_UNESCAPED_UNICODE);


require_once ("../config/DB_DISCONNECT.php");
?>
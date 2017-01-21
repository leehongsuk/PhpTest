<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_korabd_gbn  = $_POST["korabd_gbn"] ;

    $a_json  = array() ;
    $a_list  = array() ;
    $a_row   = array() ;
    $a_affiliate   = array() ;
    $a_unaffiliate = array() ;


    $query= "CALL SP_LST_AFFILIATE_DIR_SEL()" ; // <-----    // 계열사와 직.위 구분
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result( $seq
                      , $affiliate_nm
                      , $code
                      , $direct_nm
                      );


    while ($stmt->fetch())
    {
        array_push($a_affiliate,array($seq,$affiliate_nm,$code,$direct_nm));
    }
    $stmt->close();


    $query= "CALL SP_LST_UNAFFILIATE_SEL()" ; // <-----    // 비계열사
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $unaffiliate_nm);


    while ($stmt->fetch())
    {
        array_push($a_unaffiliate,array($seq,$unaffiliate_nm));
    }
    $stmt->close();


    foreach ($a_affiliate as $affiliate)
    {
        $p1 = $post_korabd_gbn;
        $p2 = $affiliate[0];
        $p3 = $affiliate[2];

        $query= "CALL SP_LST_PREMIUM_RATE_BY_AFFILIATE_SEL(?,?,?)" ; // <-----    // 계열사,직위별 부율구하기
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param( "sis"
                         , $p1
                         , $p2
                         , $p3
                         );
        $stmt->execute();

        $stmt->bind_result( $seq
                          , $location_nm
                          , $premium_rate
                          );

        $a_row = array("a_seq" => $affiliate[0]
                       ,"a_affiliate_nm" => $affiliate[1]
                       ,"id_code" => $affiliate[2]
                       ,"id_direct_nm" => $affiliate[3]
                       ,"ua_seq" => ""
                       ,"ua_affiliate_nm" => ""
                       ,"title1" => $affiliate[1]
                       ,"title2" => $affiliate[3]) ;

        while ($stmt->fetch())
        {
            $a_row[$seq] = $premium_rate ;
        }
        $stmt->close();

        array_push($a_list, $a_row);
    }

    foreach ($a_unaffiliate as $unaffiliate)
    {
        $p1 = $post_korabd_gbn;
        $p2 = $unaffiliate[0];

        $query= "CALL SP_LST_PREMIUM_RATE_BY_UNAFFILIATE_SEL(?,?)" ; // <-----    // 비계열사별 부율구하기
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param( "si"
                         , $p1
                         , $p2
                         );
        $stmt->execute();

        $stmt->bind_result( $seq
                          , $location_nm
                          , $premium_rate
                          );

        $a_row = array("a_seq" => ""
                       ,"a_affiliate_nm" => ""
                       ,"id_code" => ""
                       ,"id_direct_nm" => ""
                       ,"ua_seq" => $unaffiliate[0]
                       ,"ua_affiliate_nm" => $unaffiliate[1]
                       ,"title1" => ""
                       ,"title2" => $unaffiliate[1]) ;

         while ($stmt->fetch())
        {
             $a_row[$seq] = $premium_rate ;
        }
        $stmt->close();

        array_push($a_list, $a_row);
    }

    $a_json = array("result" => "ok", "list" => $a_list, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
<?php
require_once("../config/CONFIG.php");

require_once("../config/DB_CONNECT.php");

    $values = "" ;
    $separator = "|" ;

    foreach( $_REQUEST as $key => $val )
    {
        if  ($key == "KorabdGbn") $korabd_gbn = $val ;
        else
       {
            if  (strlen($values) > 0)  $values .= $separator ;

            $values .= ($key."=".$val) ;
        }
        //list($tmp,$loc_cd, $affiliate_seq, $isdirect_cd, $unaffiliate) = split('_', $key);

        //echo $key."=".$val."<br>";
        //echo $loc_cd.",".$affiliate_seq.",".$isdirect_cd.",".$unaffiliate ."=".$val."<br>";
    }
    echo $values ;

    $query= "CALL  SP_BAS_PREMIUM_RATE_UPDATE(?,?,?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("sss",$korabd_gbn,$values,$separator);
    $stmt->execute();
    $stmt->close();


require_once("../config/DB_DISCONNECT.php");
?>
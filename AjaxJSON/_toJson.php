<?php
require_once("../config/CONFIG.php");

require_once("../config/DB_CONNECT.php");

    $a_list  = array() ;


    //$query= "CALL  SP_BAS_AFFILIATE_SEL()";
    //$query= "CALL  SP_BAS_GENRE_SEL()";
    $query= "select * from WRK_THEATER";

    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $result = $stmt->get_result();    //$num_of_rows = $result->num_rows;

    print_r($result);

    while ($row = $result->fetch_assoc())
    {
        array_push($a_list,$row);     //print_r($row);
        //echo 'seq: '.$row['SEQ'].'  affiliate_nm: '.$row['AFFILIATE_NM'].'<br><br>';
    }

    $stmt->free_result();

    $stmt->close();


require_once("../config/DB_DISCONNECT.php");

//echo json_encode($a_list,JSON_UNESCAPED_UNICODE);
//echo $a_list;
?>
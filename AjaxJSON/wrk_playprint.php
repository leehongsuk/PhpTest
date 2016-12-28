<?php
require_once("../config/CONFIG.php");

$PhpSelf = $_SERVER['PHP_SELF'];
require_once("../config/DB_CONNECT.php");

    $post_film_code  = $_POST["film_code"] ;

    $a_json  = array() ;
    $a_list  = array() ;


    $query= "CALL  SP_WRK_PLAYPRINT_SEL(?)";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_film_code);
    $stmt->execute();

    $stmt->bind_result($seq,$film_code,$playprint1,$playprint2,$memo);


    while ($stmt->fetch())
    {
        array_push($a_list, array("seq" => $seq
                                  ,"film_code" => $film_code
                                  ,"playprint1" => $playprint1
                                  ,"playprint2" => $playprint2
                                  ,"memo" => $memo
                                  )
                  );
    }
    $stmt->close();

    $a_json = array("result" => "ok", "list" => $a_list, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
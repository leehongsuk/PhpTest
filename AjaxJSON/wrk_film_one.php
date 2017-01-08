<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_code = $_POST["code"] ;

    $a_json      = array() ;
    $a_playprint = array() ;


    $query= "CALL SP_WRK_FILM_PLAYPRINT_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result($seq
                      ,$film_code
                      ,$playprint1_seq
                      ,$playprint1_nm
                      ,$playprint2_seq
                      ,$playprint2_nm
                      ,$memo
                      );



    while ($stmt->fetch())
    {
        array_push($a_playprint, array("seq" => $seq
                                       ,"film_code" => $film_code
                                       ,"playprint1_seq" => $playprint1_seq
                                       ,"playprint1_nm" => $playprint1_nm
                                       ,"playprint2_seq" => $playprint2_seq
                                       ,"playprint2_nm" => $playprint2_nm
                                       ,"memo" => $memo
                                       )
                  ) ;
    }
    $stmt->close();


    $query= "CALL SP_WRK_FILM_SEL_ONE(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result($code
                      ,$distributor_seq
                      ,$distributor_cd
                      ,$film_nm
                      ,$grade_seq
                      ,$first_play_dt
                      ,$open_dt
                      ,$close_dt
                      ,$reopem_dt
                      ,$reclose_dt
                      ,$poster_yn
                      ,$images_no
                      ,$korabd_cd
                      ,$del_flag
                      );

    if ($stmt->fetch())
    {
        $a_json = array("code" => $code
                        ,"distributor_seq" => $distributor_seq
                        ,"distributor_cd" => $distributor_cd
                        ,"film_nm" => $film_nm
                        ,"grade_seq" => $grade_seq
                        ,"first_play_dt" => $first_play_dt
                        ,"open_dt" => $open_dt
                        ,"close_dt" => $close_dt
                        ,"reopem_dt" => $reopem_dt
                        ,"reclose_dt" => $reclose_dt
                        ,"poster_yn" => $poster_yn
                        ,"images_no" => $images_no
                        ,"korabd_cd" => $korabd_cd
                        ,"del_flag" => $del_flag

                        ,"playprints" => $a_playprint
                        );
    }
    $stmt->close();



require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
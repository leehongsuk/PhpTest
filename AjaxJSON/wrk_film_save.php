<?php
require_once ("../config/CONFIG.php");
require_once ("../config/DB_CONNECT.php");

    print_r ( $_REQUEST );
/*
    foreach ( $_REQUEST as $key => $val )
    {
        echo $key."=".$val."<br>";
    }
print_r( $_POST["contacts"] );
print_r( $_POST["showroom"] );
print_r( $_POST["playprint"] );
 * */

    $post_code             = $_POST["code"] ;
    $post_distributor_seq  = $_POST["distributor_seq"] ;
    $post_distributor_cd   = $_POST["distributor_cd"] ;
    $post_film_nm          = $_POST["film_nm"] ;
    $post_grade_seq        = $_POST["grade_seq"] ;
    $post_first_play_dt    = $_POST["first_play_dt"] ;
    $post_open_dt          = $_POST["open_dt"] ;
    $post_close_dt         = $_POST["close_dt"] ;
    $post_reopem_dt        = $_POST["reopem_dt"] ;
    $post_reclose_dt       = $_POST["reclose_dt"] ;
    $post_poster_yn        = ($_POST["poster_yn"]=="Y")?"Y":"N" ;
    $post_images_no        = $_POST["images_no"] ;
    $post_korabd_cd        = $_POST["korabd_cd"] ;

    if  (isset($_POST["genres"]))  $post_genres = implode(",", $_POST["genres"]) ; // 장르 ..

    $post_playprints      = $_POST["playprints"] ; // 상영프린트 JSON



    $query= "CALL SP_WRK_FILM_SAVE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,@newCode,@output)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("sississssssiss"
                     ,$post_code
                     ,$post_distributor_seq
                     ,$post_distributor_cd
                     ,$post_film_nm
                     ,$post_grade_seq
                     ,$post_first_play_dt
                     ,$post_open_dt
                     ,$post_close_dt
                     ,$post_reopem_dt
                     ,$post_reclose_dt
                     ,$post_poster_yn
                     ,$post_images_no
                     ,$post_korabd_cd
                     ,$post_genres
                     );
    $stmt->execute();
/*

    //echo $stmt->mysql_errno . ": " . $stmt->mysql_error;

    $stmt->close();

    $result = $mysqli->query('SELECT @newCode,@output');
    list($newCode,$output) = $result->fetch_row();

    //print_r ( "[".$newCode."]" );

    $theater_code = ($newCode!="") ? $newCode : $post_code ;


    // 상영프린트를 받아온다.
    $contacts = json_decode($post_playprints);

    foreach ($contacts as $key => $value)
    {
        $_CUD             = $contacts[$key]->_CUD ;
        $seq              = $contacts[$key]->seq ;
        //$theater_code     = $contacts[$key]->theater_code ;
        $playprint_seq  = $contacts[$key]->playprint_seq ;
        $theater_knm      = $contacts[$key]->theater_knm ;
        $theater_enm      = $contacts[$key]->theater_enm ;
        $theater_dcode    = $contacts[$key]->theater_dcode ;

        //print_r ( $contacts[$key] );
        //print_r ( $_CUD ." : ".$seq." | ".$theater_code." | ".$playprint_seq." | ".$theater_knm." | ".$theater_enm." | ".$theater_dcode." | " );
        //print_r ( "\n" );

        if  ($_CUD != "")
        {
            $query= "CALL SP_WRK_THEATER_PLAYPRINT_SAVE(?,?,?,?,?,?,?)" ; // <-----
            $stmt = $mysqli->prepare($query);

            $stmt->bind_param("sisisss"
              ,$_CUD
              ,$seq
              ,$theater_code
              ,$playprint_seq
              ,$theater_knm
              ,$theater_enm
              ,$theater_dcode
              );
            $stmt->execute();
            $stmt->close();
        }
    }

    // 결과만 반환한다.
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
*/

require_once ("../config/DB_DISCONNECT.php");
?>
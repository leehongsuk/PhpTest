<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    $post_mode = $_POST["mode"] ;
    $post_code = $_POST["code"] ;

    $a_json      = array() ;
    $a_playprint = array() ;

    // 배급사 리스트
    $a_distributors  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_DISTRIBUTOR_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $distributor_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $distributor_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_distributors = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 배급사 리스트 ...

    // 장르 리스트 ...
    $a_genres  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_FILM_GENRE_SEL(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_code);
    $stmt->execute();

    $stmt->bind_result( $seq
                      , $genre_nm
                      , $genre_seq
                      );

    while ($stmt->fetch())
    {
        array_push($a_list, array( "seq" => $seq
                                 , "genre_nm" => $genre_nm
                                 , "genre_seq" => $genre_seq
                               )
                  ) ;
    }
    $stmt->close();

    $a_genres = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 장르 리스트 ...

    // 방화외화 리스트 ...
    $a_korabdgbns  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_KORABD_GBN_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($code, $gbn_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $code
                                 , "optionText" => $gbn_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_korabdgbns = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 방화외화 리스트 ...

    // 등급 리스트 ...
    $a_grade  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_GRADE_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $grade_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $grade_nm
                                 )
                  ) ;

    }
    $stmt->close();

    $a_grade = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 등급 리스트 ...

    // 상영프린트 1 기초자료 리스트
    $a_playprint1  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_PLAYPRINT1_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $play_print_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $play_print_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_playprint1 = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 상영프린트 1 기초자료 리스트

    // 상영프린트 2 기초자료 리스트
    $a_playprint2  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_PLAYPRINT2_SEL()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($seq, $play_print_nm);

    while ($stmt->fetch())
    {
        array_push($a_list, array( "optionValue" => $seq
                                 , "optionText" => $play_print_nm
                                 )
                  ) ;
    }
    $stmt->close();

    $a_playprint2 = array("result" => "ok", "options" => $a_list,"etcs" => "");
    // 상영프린트 2 기초자료 리스트




    if  ($post_mode=="EDIT")
    {
        $query= "CALL SP_WRK_FILM_PLAYPRINT_SEL(?)" ; // <-----
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $post_code);
        $stmt->execute();

        $stmt->bind_result( $seq
                          , $film_code
                          , $playprint1_seq
                          , $playprint1_nm
                          , $playprint2_seq
                          , $playprint2_nm
                          , $memo
                          , $cnt_theater
                          , $cnt_showroom
                          );

        while ($stmt->fetch())
        {
            array_push($a_playprint, array( "seq" => $seq
                                          , "film_code" => $film_code
                                          , "playprint1_seq" => $playprint1_seq
                                          , "playprint1_nm" => $playprint1_nm
                                          , "playprint2_seq" => $playprint2_seq
                                          , "playprint2_nm" => $playprint2_nm
                                          , "memo" => $memo
                                          , "cnt_theater" => $cnt_theater
                                          , "cnt_showroom" => $cnt_showroom
                                          )
                      ) ;
        }
        $stmt->close();


        $query= "CALL SP_WRK_FILM_SEL_ONE(?)" ; // <-----
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("s", $post_code);
        $stmt->execute();

        $stmt->bind_result( $code
                          , $distributor_seq
                          , $distributor_cd
                          , $film_nm
                          , $grade_seq
                          , $first_play_dt
                          , $open_dt
                          , $close_dt
                          , $reopen_dt
                          , $reclose_dt
                          , $poster_yn
                          , $images_no
                          , $korabd_cd
                          );

        if ($stmt->fetch())
        {
            $a_json = array( "code" => $code
                           , "distributor_seq" => $distributor_seq
                           , "distributor_cd" => $distributor_cd
                           , "film_nm" => $film_nm
                           , "grade_seq" => $grade_seq
                           , "first_play_dt" => $first_play_dt
                           , "open_dt" => $open_dt
                           , "close_dt" => $close_dt
                           , "reopen_dt" => $reopen_dt
                           , "reclose_dt" => $reclose_dt
                           , "poster_yn" => $poster_yn
                           , "images_no" => $images_no
                           , "korabd_cd" => $korabd_cd
                           , "playprints" => $a_playprint
                           , "distributors" => $a_distributors
                           , "genres" => $a_genres
                           , "korabdgbns" => $a_korabdgbns
                           , "grade" => $a_grade
                           , "playprint1" => $a_playprint1
                           , "playprint2" => $a_playprint2
                           );
        }
        $stmt->close();
    }

    if  ($post_mode=="APPEND")
    {
        $a_json = array( "code" => ""
                       , "distributor_seq" => $distributor_seq
                       , "distributor_cd" => $distributor_cd
                       , "film_nm" => $film_nm
                       , "grade_seq" => $grade_seq
                       , "first_play_dt" => $first_play_dt
                       , "open_dt" => $open_dt
                       , "close_dt" => $close_dt
                       , "reopen_dt" => $reopen_dt
                       , "reclose_dt" => $reclose_dt
                       , "poster_yn" => $poster_yn
                       , "images_no" => $images_no
                       , "korabd_cd" => $korabd_cd
                       , "playprints" => $a_playprint
                       , "distributors" => $a_distributors
                       , "genres" => $a_genres
                       , "korabdgbns" => $a_korabdgbns
                       , "grade" => $a_grade
                       , "playprint1" => $a_playprint1
                       , "playprint2" => $a_playprint2
                       );
     }


    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
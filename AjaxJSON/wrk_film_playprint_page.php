<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_distributor_seq  = $_POST["distributor_seq"] ;
    $post_film_nm          = $_POST["film_nm"] ;
    $post_pageNo           = $_POST["pageNo"] ;
    $post_pageSize         = $_POST["pageSize"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_WRK_FILM_PLAYPRINT_SEL_COUNT(?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("is"
                     , $post_distributor_seq
                     , $post_film_nm
                     );
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_WRK_FILM_PLAYPRINT_SEL_PAGE(?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("isii"
                     , $post_distributor_seq
                     , $post_film_nm
                     , $post_pageNo
                     , $post_pageSize
                     );
    $stmt->execute();

    $stmt->bind_result($code
                      ,$distributor_seq
                      ,$distributor_nm
                      ,$distributor_cd
                      ,$film_nm
                      ,$grade_nm
                      ,$first_play_dt
                      ,$open_dt
                      ,$close_dt
                      ,$reopen_dt
                      ,$reclose_dt
                      ,$poster_yn
                      ,$images_no
                      ,$korabd_gbn_nm
                      ,$del_flag
                      ,$play_print1_nm
                      ,$play_print2_nm
                      );

    while ($stmt->fetch())
    {
        array_push($a_list, array("code" => $code
                                  ,"distributor_seq" => $distributor_seq
                                  ,"distributor_nm" => $distributor_nm
                                  ,"distributor_cd" => $distributor_cd
                                  ,"film_nm" => $film_nm
                                  ,"grade_nm" => $grade_nm
                                  ,"first_play_dt" => $first_play_dt
                                  ,"open_dt" => $open_dt
                                  ,"close_dt" => $close_dt
                                  ,"play_term" => $open_dt ." ~ ". $close_dt
                                  ,"reopen_dt" => $reopen_dt
                                  ,"reclose_dt" => $reclose_dt
                                  ,"replay_term" => $reopen_dt ." ~ ". $reclose_dt
                                  ,"poster_yn" => $poster_yn
                                  ,"images_no" => $images_no
                                  ,"korabd_gbn_nm" => $korabd_gbn_nm
                                  ,"cnt_playprint" => $cnt_playprint
                                  ,"play_print_nm" => $play_print1_nm ." ". $play_print2_nm
                                  )
                  );
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
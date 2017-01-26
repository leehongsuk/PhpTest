<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    $post_play_dt       = $_POST["play_dt"] ; // 상영일..
    $post_theater_code  = $_POST["theater_code"] ;
    $post_showroom_seq  = $_POST["showroom_seq"] ;
    $post_film_code     = $_POST["film_code"] ;
    $post_playprint_seq = $_POST["playprint_seq"] ;

    //$post_korabd_gbn  = $_POST["korabd_gbn"] ;

    $a_json  = array() ;
    $a_list  = array() ;
    $a_row   = array() ;
    $a_score = array() ; // 일자-상영관-영화 에 해당하는 스코어를 구한다.
    $a_score_agosum = array();
    $a_sum_score = array() ;
    $a_sum_price = array() ;
    $a_play_mast = array() ;


    $query= "CALL SP_WRK_THEATER_UNITPRICE_SELECTED_SEL(?)" ; // <-----    // 한 극장의 선택된 단가리스트
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_theater_code);
    $stmt->execute();

    $stmt->bind_result($seq, $unit_price); // 가격일련번호와 가격값

    while ($stmt->fetch())
    {
        $a_row["price_seq"] = $seq ;        // 가격일련번호
        $a_row["price"] = number_format( $unit_price ) ; // 가격값

        for ($seq=0 ; $seq <= 15 ; $seq++) // 0~15회차
        {
            $name=  "inn".$seq ;

            $a_row[$name] = "" ; // 스코어 - 초기화
        }

        //$a_row["sum"] = 100 ;

        array_push($a_list,$a_row); // 가격별로 한가격씩 한줄을 생성한다.

        // 단가에 해당하는 회차별 스코어를 구해야 한다.

    }
    $stmt->close();

    $a_row = array("price" => "합계"); // '합계' 한줄을 생성한다.
    array_push($a_list,$a_row);

    $a_row = array("price" => "금액"); // '금액' 한줄을 생성한다.
    array_push($a_list,$a_row);

    $a_row = array("price" => "전일"); // '전일' 한줄을 생성한다.
    array_push($a_list,$a_row);


    // 스코어 정보 (당일)
    $query= "CALL SP_WRK_PLAY_DETAIL_CUR_SEL(?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "ssisi"
                     , $post_play_dt
                     , $post_theater_code
                     , $post_showroom_seq
                     , $post_film_code
                     , $post_playprint_seq
                     );
    $stmt->execute();

    $stmt->bind_result( $unitprice_seq
                      , $unit_price
                      , $inning_seq
                      , $inning_nm
                      , $score
                      );

    while ($stmt->fetch())
    {
        array_push($a_score,array($unitprice_seq, $unit_price, $inning_seq, $inning_nm, $score));
    }
    $stmt->close();
    // 스코어 정보 (당일)


    // 스코어 정보 (전일)
    $query= "CALL SP_WRK_PLAY_DETAIL_AGO_SEL(?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "ssisi"
                     , $post_play_dt
                     , $post_theater_code
                     , $post_showroom_seq
                     , $post_film_code
                     , $post_playprint_seq
                     );
    $stmt->execute();

    $stmt->bind_result( $sum0
                      , $sum1
                      , $sum2
                      , $sum3
                      , $sum4
                      , $sum5
                      , $sum6
                      , $sum7
                      , $sum8
                      , $sum9
                      , $sum10
                      , $sum11
                      , $sum12
                      , $sum13
                      , $sum14
                      , $sum15
                      );

    if ($stmt->fetch())
    {
        array_push($a_score_agosum,array( $sum0
                                        , $sum1
                                        , $sum2
                                        , $sum3
                                        , $sum4
                                        , $sum5
                                        , $sum6
                                        , $sum7
                                        , $sum8
                                        , $sum9
                                        , $sum10
                                        , $sum11
                                        , $sum12
                                        , $sum13
                                        , $sum14
                                        , $sum15
                                        )
                  );
    }
    $stmt->close();
    // 스코어 정보 (전일)



    foreach ($a_score as $score) // 퍼온가격정보 전체를 돌면서
    {
        $i = 0 ;
        foreach ($a_list as $list) // 각 가격대별로 다시 돌고
        {
            if  ($score[0] == $list["price_seq"]) // 단가 일련번호가 일치하면
            {
                $a_list[$i][ "inn".$score[2] ] = $score[4] ; // 스코어 대입 !!
            }

            $i++;
        }
        //$a_row["sum"] = 100 ;
    }

    $i = 0 ;
    $sumScore = 0 ;
    $sumPrice = 0 ;
    foreach ($a_list as $list) // 각 가격대별로 다시 돌고
    {
        //print_r($a_list[$i]["price"]);
        if  (($a_list[$i]["price"] != "합계") && ($a_list[$i]["price"] != "금액") && ($a_list[$i]["price"] != "전일"))
        {
            $a_list[$i]["sum"] = 0 ;

            for ($j=0 ; $j <= 15 ; $j++) // 0~15회차
            {
                $a_list[$i]["sum"] += $a_list[$i]["inn".$j]; // 스코어

                //if  ($j==1) echo $a_list[$i]["price"].":".$i."/".$j."/".$a_list[$i]["inn".$j]."|       ";
                $a_sum_score["inn".$j] += $a_list[$i]["inn".$j];
                $a_sum_price["inn".$j] += $a_list[$i]["inn".$j] * $a_list[$i]["price"] ;
            }

            $sumScore += $a_list[$i]["sum"];
            $sumPrice += $a_list[$i]["sum"] * $a_list[$i]["price"];
        }
        if  ($a_list[$i]["price"] == "합계")
        {
            $a_list[$i]["sum"] = number_format( $sumScore );
            for ($j=0 ; $j <= 15 ; $j++) // 0~15회차
            {
                $a_list[$i]["inn".$j] = $a_sum_score["inn".$j];
            }
        }
        if  ($a_list[$i]["price"] == "금액")
        {
            $a_list[$i]["sum"] = number_format( $sumPrice );
            for ($j=0 ; $j <= 15 ; $j++) // 0~15회차
            {
                $a_list[$i]["inn".$j] = $a_sum_price["inn".$j];
            }
        }
        if  ($a_list[$i]["price"] == "전일")
        {
            $sumsumPrice = 0 ;

            for ($j=0 ; $j <= 15 ; $j++) // 0~15회차
            {
               $a_list[$i]["inn".$j] = $a_score_agosum[0][$j];

               $sumsumPrice += $a_score_agosum[0][$j];
            }

            $a_list[$i]["sum"] = number_format( $sumsumPrice );
        }
        $i++;
    }



    // play_mast 정보를 구한다...
    $query= "SELECT THEATER_NM
                   ,ROOM_NM
                   ,FILM_NM
                   ,PLAY_PRINT_NM1
                   ,PLAY_PRINT_NM2
                   ,CONFIRM
                   ,MEMO
               FROM VW_WRK_PLAY_MAST
              WHERE THEATER_CODE  = ?
                AND SHOWROOM_SEQ  = ?
                AND FILM_CODE     = ?
                AND PLAYPRINT_SEQ = ?
            " ;
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "sisi"
                     , $post_theater_code
                     , $post_showroom_seq
                     , $post_film_code
                     , $post_playprint_seq
                     );
    $stmt->execute();

    $stmt->bind_result( $theater_nm
                      , $room_nm
                      , $film_nm
                      , $play_print_nm1
                      , $play_print_nm2
                      , $confirm
                      , $memo
                      );

    if ($stmt->fetch())
    {
        array_push($a_play_mast,array( "theater_nm" => $theater_nm
                                     , "room_nm" => $room_nm
                                     , "film_nm" => $film_nm
                                     , "play_print_nm1" => $play_print_nm1
                                     , "play_print_nm2" => $play_print_nm2
                                     , "confirm" => $confirm
                                     , "memo" => $memo

                                     )
                  );
    }
    $stmt->close();
    // play_mast 정보를 구한다...


    $a_json = array("result" => "ok", "list" => $a_list, "play_mast" => $a_play_mast,"msg" => "");

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
<?php
$a_json = array() ;

if  ($_SESSION['user_seq'])
{
    require_once("../config/CONFIG.php");
    require_once("../config/DB_CONNECT.php");

    $post_price_seqs     = $_POST["price_seqs"] ;
    $post_play_dt        = $_POST["play_dt"] ;
    $post_theater_code   = $_POST["theater_code"] ;
    $post_showroom_seq   = $_POST["showroom_seq"] ;
    $post_film_code      = $_POST["film_code"] ;
    $post_playprint_seq  = $_POST["playprint_seq"] ;
    $post_confirm        = ($_POST["confirm"]=="확인") ? "Y" : "N";
    $post_memo           = $_POST["memo"] ;


    $query= "CALL SP_WRK_PLAY_MAST_UPDATE(?,?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "sisiss"
                     , $post_theater_code
                     , $post_showroom_seq
                     , $post_film_code
                     , $post_playprint_seq
                     , $post_confirm
                     , $post_memo
                     );
    $stmt->execute();
    $stmt->close();


    $separator = "," ;

    $price_seqs = explode (",", $post_price_seqs); // 가격대 분리

    for ($i = 0 ; $i < count($price_seqs) ; $i++) // 가격대로 순환 ..
    {
        $price_vals = "" ;

        foreach( $_REQUEST as $key => $val ) // 모든 post요소를 다 뒤집어본다..
        {
            if  (substr($key, 0, 3) == "pd_")
            {
                $keys = explode ("_", $key); // 스코어 키 이름 분리 3개(pd_2_inn7)

                if  ($price_seqs[$i] == $keys[1]) // 키와 요금일련번호가 일치하면..
                {
                    for  ($j = 0 ; $j <= 15 ; $j++) // 회차만큼 ..
                    {
                        if  (substr($keys[2], 3) == $j) // inn7 에서 7 에 해당하는것과 회차비교.. 순서체크..
                        {
                            if  ($j != 0) $price_vals .= "," ;

                            $price_vals .= $val ;
                        }
                    }
                }
            }
        }

        //print_r($price_vals."\n");

        $query= "CALL SP_WRK_PLAY_DETAIL_SAVE(?,?,?,?,?,?,?,?)" ; // <-----
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param( "ssisiiss"
                         , $post_play_dt
                         , $post_theater_code
                         , $post_showroom_seq
                         , $post_film_code
                         , $post_playprint_seq
                         , $price_seqs[$i]
                         , $price_vals
                         , $separator
                         );
        $stmt->execute();
        $stmt->close();
    }

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
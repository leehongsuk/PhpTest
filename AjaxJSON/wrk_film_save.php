<?php
require_once ("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once ("../config/DB_CONNECT.php");

    /*
        print_r ( $_REQUEST );
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
    $post_first_play_dt    = ($_POST["first_play_dt"]!="")?$_POST["first_play_dt"]:null ;
    $post_open_dt          = ($_POST["open_dt"]!="")?$_POST["open_dt"]:null ;
    $post_close_dt         = ($_POST["close_dt"]!="")?$_POST["close_dt"]:null ;
    $post_reopen_dt        = ($_POST["reopen_dt"]!="")?$_POST["reopen_dt"]:null ;
    $post_reclose_dt       = ($_POST["reclose_dt"]!="")?$_POST["reclose_dt"]:null ;
    $post_poster_yn        = ($_POST["poster_yn"]=="Y")?"Y":"N" ;
    $post_images_no        = $_POST["images_no"] ;
    $post_korabd_cd        = ($_POST["korabd_cd"]=="A")?"A":"K" ;

    if  (isset($_POST["genres"]))  $post_genres = implode(",", $_POST["genres"]) ; // 장르 ..

    $post_playprints      = $_POST["playprints"] ; // 상영프린트 JSON


    $query= "CALL SP_WRK_FILM_SAVE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,@newCode,@output)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "sississssssiss"
                     , $post_code
                     , $post_distributor_seq
                     , $post_distributor_cd
                     , $post_film_nm
                     , $post_grade_seq
                     , $post_first_play_dt
                     , $post_open_dt
                     , $post_close_dt
                     , $post_reopen_dt
                     , $post_reclose_dt
                     , $post_poster_yn
                     , $post_images_no
                     , $post_korabd_cd
                     , $post_genres
                     );
    $stmt->execute();
    $stmt->close();

    $result = $mysqli->query('SELECT @newCode,@output');
    list($newCode,$output) = $result->fetch_row();

    $film_code = ($newCode!="") ? $newCode : $post_code ;


    // 상영프린트를 받아온다.
    $playprints = json_decode($post_playprints);


    if  ($playprints!=null)
    {
        foreach ($playprints as $key => $value)
        {
            $_CUD           = $playprints[$key]->_CUD ;
            $seq            = $playprints[$key]->seq ;
            $playprint1_seq = $playprints[$key]->playprint1_seq ;
            $playprint2_seq = $playprints[$key]->playprint2_seq ;
            $memo           = $playprints[$key]->memo ;

            //print_r ( $playprints[$key] );
            //print_r ( $_CUD ." : ".$seq." | ".$film_code." | ".$playprint_seq." | ".$film_knm." | ".$film_enm." | ".$film_dcode." | " );
            //print_r ( "\n" );

            if  ($_CUD != "")
            {
                $query= "CALL SP_WRK_FILM_PLAYPRINT_SAVE(?,?,?,?,?,?)" ; // <-----
                $stmt = $mysqli->prepare($query);

                $stmt->bind_param( "sisiis"
                                 , $_CUD
                                 , $seq
                                 , $film_code
                                 , $playprint1_seq
                                 , $playprint2_seq
                                 , $memo
                                 );
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    require_once ("../config/DB_DISCONNECT.php");

    // 결과만 반환한다.
    if  ($output==1)  $a_json = array("result" => "ok",  "output" => $output, "msg" => "저장이 완료되었습니다.");
    else              $a_json = array("result" => "err", "output" => $output, "msg" => "저장 중 오류가 발생하였습니다.");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
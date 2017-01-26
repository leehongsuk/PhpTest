<?php
require_once ("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once ("../config/DB_CONNECT.php");

    $a_json = array() ;


    $post_theater_code   = $_POST["theater_code"] ;
    $post_showroom_seq   = $_POST["showroom_seq"] ;
    $post_film_code      = $_POST["film_code"] ;
    $post_playprint_seq  = $_POST["playprint_seq"] ;
    $post_change_value   = $_POST["change_value"] ; //  (=='지정') ? 'Y' : 'N'


    $query= "CALL SP_WRK_PLAY_MAST_CREATE(?,?,?,?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "sisis"
                     , $post_theater_code
                     , $post_showroom_seq
                     , $post_film_code
                     , $post_playprint_seq
                     , $post_change_value
                     );
    $stmt->execute();
    $stmt->close();

    require_once ("../config/DB_DISCONNECT.php");

    // 결과만 반환한다.
    $a_json = array("result" => "ok",  "msg" => "저장이 완료되었습니다.");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
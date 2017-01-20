<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $post_user_id   = $_POST["user_id"] ;
    $post_user_pw   = Hex2String($_POST["user_pw"]) ;  // 암호를 복호화 한다.

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_USR_LOGIN_ID_CHECK(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $post_user_id);
    $stmt->execute();

    $stmt->bind_result($count,$del_flag,$delete_dt );


    if ($stmt->fetch())
    {
         $a_json["count_id"]  = $count;
         $a_json["del_flag"]  = $del_flag;
         $a_json["delete_dt"] = $delete_dt;
    }

    $stmt->close();

    if  ($count == 1) // 아이디가 존재하고..
    {
        if ($del_flag == "N") // 삭제되지않을 경우..
        {
            $query= "CALL SP_USR_LOGIN_IDPW_CHECK(?,?)" ; // <-----
            $stmt = $mysqli->prepare($query);

            $stmt->bind_param("ss", $post_user_id, $post_user_pw);
            $stmt->execute();

            $stmt->bind_result($count,$user_seq );

            if ($stmt->fetch())
            {
                $a_json["count_idpw"] = $count;
                $a_json["user_seq"]   = $user_seq;

                if  ($count==1) $_SESSION['user_seq'] = $user_seq; // 로그인에 성공하였으므로 바로 세션은 만든다.
            }
        }
    }

    /*

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");
    */

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
<?php
require_once ("../config/CONFIG.php");
require_once ("../config/DB_CONNECT.php");





    $seq           = -1;
    $post_user_id  = $_POST["user_id"] ;
    $post_user_pw  = Hex2String($_POST["user_pw"]) ; // 암호를 복호화 한다.
    $post_user_nm  = $_POST["user_nm"] ;
    $post_tel      = $_POST["tel"] ;
    $post_hp       = $_POST["hp"] ;
    $post_fax      = $_POST["fax"] ;
    $post_email    = $_POST["email"] ;

    $query= "CALL SP_USR_USER_SAVE(?,?,?,?,?,?,?,?,@newCode,@output)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "isssssss"
                     , $seq
                     , $post_user_id
                     , $post_user_pw
                     , $post_user_nm
                     , $post_tel
                     , $post_hp
                     , $post_fax
                     , $post_email
                     );
    $stmt->execute();
    $stmt->close();

    $result = $mysqli->query('SELECT @newSeq,@output');
    list($newSeq,$output) = $result->fetch_row();

    if ($newSeq!="")
    {
       // 사용자 등록이 성공적일때...
    }


    // 결과만 반환한다.
    echo json_encode($output,JSON_UNESCAPED_UNICODE);


require_once ("../config/DB_DISCONNECT.php");
?>
<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    // $_SERVER["DOCUMENT_ROOT"]
    $file_server_path = realpath(__FILE__);
    $server_path = str_replace(basename(__FILE__), "", $file_server_path);
    $upload_dir = $server_path . "files";

    //echo $server_path . "files\\"."<br>";
    //echo $_POST["uploadedPath"]."<br>";
    //echo $_POST["saveName"]."<br>";

    //$upload_dir = $_SERVER["DOCUMENT_ROOT"] . $_POST["uploadedPath"]; // 주의!!!

    //$upload_dir = $_POST["uploadedPath"]; // 업로드된 파일이 있는 디렉토리 경로
    $file	    = $_POST["saveName"];     // 파일명

    //echo $upload_dir . $file ."<br>";

    if  ( is_file($upload_dir . "/" . $file) )
    {
        unlink($upload_dir . "/" . $file);

        //echo "{result:'ok', msg:''}";
        $a_json = array("result" => "ok", "msg" => "");

        $query= "CALL SP_WRK_UPLOADED_IMAGES_DELETE(?)" ; // <-----
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $file );
        $stmt->execute();
        $stmt->close();
    }
    else
    {
        //echo "{result:'err', msg:'". "파일을 찾을 수 없습니다.". $upload_dir ."'}";
        $a_json = array("result" => "err", "msg" => "파일을 찾을 수 없습니다. $upload_dir");
    }

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
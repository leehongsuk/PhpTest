<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    $a_json  = array() ;

    // $_SERVER["DOCUMENT_ROOT"]
    $file_server_path = realpath(__FILE__);
    $server_path = str_replace(basename(__FILE__), "", $file_server_path);
    $upload_dir = $server_path . "files";
    //echo $upload_dir;

    if (!$dh = @opendir($upload_dir)) {
        return false;
    }

    $seq = 0;
    while (($file = readdir($dh)) !== false)
    {
        if ($file == "." || $file == "..") continue; // . 과 .. 디렉토리는 무시

        array_push($a_json, array("id" => "MF_AX_$seq"
                                  ,"name" => $file
                                  ,"saveName" => $file
                                  ,"type" => filetype($upload_dir."/".$file)
                                  ,"fileSize" => filesize($upload_dir."/".$file)
                                  ,"uploadedPath" => "../AjaxJSON/files/"
                                  ,"thumbUrl" => "../AjaxJSON/files/$file"
                                  ,"mainImage" => ($seq == 0)?true:false
                              )
                   ) ;

        $seq++;
    }

    closedir($dh);

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
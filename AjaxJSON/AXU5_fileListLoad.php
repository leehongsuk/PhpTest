<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    //echo "-------------".$_GET["code"]."-------------";

    /*
     $fp = @fopen($filepath);
    if (!$fp) echo "존재하지 않습니다.";
    else fclose($fp);
     */
    // $_SERVER["DOCUMENT_ROOT"]
    $file_server_path = realpath(__FILE__);
    $server_path = str_replace(basename(__FILE__), "", $file_server_path);
    $upload_dir = $server_path . "files";
    //echo $upload_dir;

    $a_json  = array() ;

    if  ($_GET["gubun"] == 'film')    $query= "CALL SP_WRK_FILM_UPLOAD_IMAGE(?)" ; // <-----
    if  ($_GET["gubun"] == 'theater') $query= "CALL SP_WRK_THEATER_UPLOAD_IMAGE(?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("s", $_GET["code"]);
    $stmt->execute();

    $stmt->bind_result($save_file);

    if ($stmt->fetch())
    {
        if  ($save_file != null) // 등록된 파일이 없다면....
        {
            $fp = fopen($upload_dir."/".$save_file,"r"); // 실제 디렉토리에 존재하는지 확인...
            if ($fp)
            {
                $seq = 0;
                array_push($a_json, array( "id" => "MF_AX_$seq"
                                         , "name" => $save_file
                                         , "saveName" => $save_file
                                         , "type" => filetype($upload_dir."/".$save_file)
                                         , "fileSize" => filesize($upload_dir."/".$save_file)
                                         , "uploadedPath" => "../AjaxJSON/files/"
                                         , "thumbUrl" => "../AjaxJSON/files/$save_file"
                                         , "mainImage" => ($seq == 0)?true:false
                                         )
                           );

                fclose($fp);
            }
        }
    }
    $stmt->close();


    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
<?php
require_once("../config/CONFIG.php");
require_once("../config/DB_CONNECT.php");

    // $_SERVER["DOCUMENT_ROOT"]
    $file_server_path = realpath(__FILE__);
    $server_path = str_replace(basename(__FILE__), "", $file_server_path);
    $upload_dir = $server_path . "files";
    //echo $upload_dir;

    $file_name = strtolower($_FILES['fileData']['name']); // 원래 파일명
    $file_ext = strtolower(substr(strrchr($file_name, "."), 1)); // 파일 확장자
    $file_size = $_FILES['fileData']['size']; // 파일 사이즈

    do { // 임의의 중복되지 않는 화일명을 구한다.
        $new_file_name = "AX_" . rand(1000000000,9999999999) . "." . $file_ext;
        if (!file_exists($upload_dir . "/" . $new_file_name)) {
            break;
        }
    } while(1);

    $uploadfile = $upload_dir . "/" . basename($new_file_name);

    //print_r($_FILES); //파일정보 출력 메소드

    if (move_uploaded_file($_FILES['fileData']['tmp_name'], $uploadfile))
    {
        $imagesize = getimagesize( $uploadfile );

        $a_json = array ("name"         => $file_name
                        ,"type"         => $file_ext
                        ,"saveName"     => $new_file_name
                        ,"fileSize"     => $file_size
                        ,"uploadedPath" => "../AjaxJSON/files/"
                        ,"thumbUrl"     => "../AjaxJSON/files/$new_file_name"
                        ,"imagesize" => $imagesize
                        );

        $query= "CALL SP_WRK_UPLOADED_IMAGES_SAVE(?,?,?,?,?)" ; // <-----
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ssiii", $file_name
                                 , $new_file_name
                                 , $imagesize["0"]
                                 , $imagesize["1"]
                                 , $file_size
                                 );

        $stmt->execute();
        $stmt->close();
    }
    else
    {
        $a_json = array("error" => true);
    }

require_once("../config/DB_DISCONNECT.php");

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
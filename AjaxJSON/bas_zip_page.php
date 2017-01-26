<?php
require_once("../config/CONFIG.php");

if  ($_SESSION['user_seq'])
{
    require_once("../config/DB_CONNECT.php");

    $post_pageNo     = $_POST["pageNo"] ;
    $post_pageSize   = $_POST["pageSize"] ;

    $a_json  = array() ;
    $a_page  = array() ;
    $a_list  = array() ;


    $query= "CALL SP_BAS_ZIP_SEL_COUNT()" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $pageCount = floor($count / $post_pageSize) + ( ($count % $post_pageSize)>0 ? 1 : 0 ) ;


    $query= "CALL SP_BAS_ZIP_SEL_PAGE(?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param( "ii"
                     , $post_pageNo
                     , $post_pageSize
                     );
    $stmt->execute();

    $stmt->bind_result( $zip_code
                      , $zip_seq
                      , $si_do
                      , $kun_ku
                      , $ub_myun_dong
                      , $s_bunji1
                      , $s_bunji2
                      , $location
                      , $s_dong
                      , $e_dong
                      );


    while ($stmt->fetch())
    {
        array_push($a_list, array( "zip_code" => $zip_code
                                 , "zip_seq" => $zip_seq
                                 , "si_do" => $si_do
                                 , "kun_ku" => $kun_ku
                                 , "ub_myun_dong" => $ub_myun_dong
                                 , "s_bunji1" => $s_bunji1
                                 , "s_bunji2" => $s_bunji2
                                 , "location" => $location
                                 , "s_dong" => $s_dong
                                 , "e_dong" => $e_dong
                                 )
                  ) ;
    }
    $stmt->close();

    $a_page = array("pageNo" => $post_pageNo, "pageCount" => $pageCount,"listCount" => $post_pageSize);

    $a_json = array("result" => "ok", "list" => $a_list, "page" => $a_page, "msg" => "");

    require_once("../config/DB_DISCONNECT.php");
}
else
{
    $a_json = array("result" => "err", "msg" => "세션이 만료되었습니다.");
}

echo json_encode($a_json,JSON_UNESCAPED_UNICODE);
?>
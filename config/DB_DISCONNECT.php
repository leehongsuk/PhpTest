<?php
    $excute_end = get_time(); // 종료시간

    $excute_time = round($excute_end - $excute_start, 3);


    /*
     * 디버깅 용도로 사용할것...
     *
    $query= "INSERT INTO tmp_log_execute (exe_php, exe_time) VALUES (?,?)" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $PhpSelf, $excute_time);
    $stmt->execute();
    $stmt->close();

    $excute_time_log = $PhpSelf ." : ". $excute_time.'초';

    $query= "CALL logwrite(?)" ; // <-----
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $excute_time_log);
    $stmt->execute();
    $stmt->close();
     */



    $mysqli->close();
?>
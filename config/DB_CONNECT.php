<?php
$mysqli = new mysqli($db_host,$db_user,$db_passwd,$db_name);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$query= "CALL  logwrite(?)";
$stmt = $mysqli->prepare($query);

$stmt->bind_param("s", $PhpSelf);
$stmt->execute();
$stmt->close();

// $mysqli->set_charset("utf8"); // 한글문제로 설정(my.cfg)파일을 수정하지못할경우
?>
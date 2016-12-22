<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "l2619097";
$db_name = "test";

$con = mysql_connect($db_host,$db_user,$db_passwd);
if (!$con)
{
	die('데이터베이스 접속 실패 : ' . mysql_error());
}

mysql_select_db($db_name, $con);

$result = mysql_query("select * from test_users");
while($row = mysql_fetch_array($result))
{
	echo "NAME: ".$row["NAME"];
	echo "<br />";
}

$result = mysql_query("call pr2(0)");
while($row = mysql_fetch_array($result))
{
	echo "x: ".$row["x"];
	echo "<br />";
	echo "y: ".$row["y"];
	echo "<br />";
}

?>
<?php
$db_host = "localhost";
$db_user = "root";
$db_passwd = "l2619097";
$db_name = "test";

$mysqli = new mysqli($db_host,$db_user,$db_passwd,$db_name);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

	$query= "call pr2(?)";
	$stmt = $mysqli->prepare($query);

	$i = 1;
	$stmt->bind_param("i", $i);
	$stmt->execute();

	$stmt->bind_result($id,$x,$y);

	while ($stmt->fetch())
	{
		printf("id : %s x: %s y:%s ", $id, $x, $y);
		echo "<br />";
	}

	$stmt->close();


$mysqli->close();
?>

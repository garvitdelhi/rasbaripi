<?php

$mysqli = new mysqli('localhost', 'root', 'garvit', 'rpi');

if(isset($_POST['format']) && $_POST['format'] == "json" && isset($_POST['id'])) {
	$id = $_POST['id'];
	$q = "SELECT * FROM `status` WHERE `id` = $id";
	if($result = $mysqli->query($q)) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		print_r(json_encode($row));
		$result->close();
	}
	exit();
}

if(isset($_POST['id']) && isset($_POST['status'])) {
	$id = $_POST['id'];
	$status = $_POST['status'];
	$q = "UPDATE `rpi`.`status` SET ";
	foreach ($status as $key => $value) {
		$key = $key+1;
		$q = $q . "`status$key` = '$value', ";
	}
	$q = substr($q, 0, strlen($q)-2);
	$q = $q . " WHERE `status`.`id` = '$id'";
	// echo $q . '<br>';
	$mysqli->query($q);
}

/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$q = "SELECT * FROM `status`";
$count = 0;
if($result = $mysqli->query($q)) {
	$count = $result->num_rows;
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		foreach ($row as $key => $value) {
			echo $key . ': ' . $value . '   ';
		}
		echo "<br>";
	}
	$result->close();
}

echo '
	<br>
	<form name="status" action="index.php" method="post">
		Pid: <input name="id" type="number" min="1" max="' . $count . '"><br><br>
		Status1: <input name="status[]" type="number" min="0" max="1"><br><br>
		Status2: <input name="status[]" type="number" min="0" max="1"><br><br>
		<input type="submit">
	</form>
';

$mysqli->close();
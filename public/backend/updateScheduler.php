<?php
session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

print_r($_POST);
print_r($_SESSION);

if (isset($_POST["schedulerState"])) {

	$queryUpdate = "SET GLOBAL event_scheduler = ?";
	$stmt = mysqli_prepare($conn, $queryUpdate);
	$state = $_POST["schedulerState"];
	mysqli_stmt_bind_param($stmt, 's', $state);
	mysqli_stmt_execute($stmt);

	echo "succ";
} else {
	echo "Post vars not set";
}

<?php
// session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// print_r($_POST);

if (isset($_POST["daysPassed"])) {
	$daysPassed = $_POST["daysPassed"];

	$queryDays = "UPDATE `reservations` SET `start` = DATE(`start` + ?) `end` = DATE(`end` + 1)";
	$stmt = mysqli_prepare($conn, $queryDays);
	mysqli_stmt_bind_param($stmt, 'i', $daysPassed);
	mysqli_stmt_execute($stmt);

	echo "success";
} else {
	echo "Post vars not set";
}

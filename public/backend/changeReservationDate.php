<?php
// session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// print_r($_POST);

if (isset($_POST["id"]) && isset($_POST["start"]) && isset($_POST["end"])) {
	$reservationId = $_POST["id"];
	$newStart = $_POST["start"];
	$newEnd = $_POST["end"];

	// Change the selected reservation's dates
	$queryUserType = "UPDATE `reservations` SET `start` = ?, `end` = ? WHERE `reservations`.`id` = ?";
	$stmt = mysqli_prepare($conn, $queryUserType);
	mysqli_stmt_bind_param($stmt, 'ssi', $newStart, $newEnd, $reservationId);
	mysqli_stmt_execute($stmt);

	echo "success";
} else {
	echo "Post vars not set";
}

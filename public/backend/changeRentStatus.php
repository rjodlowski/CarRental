<?php
// session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// print_r($_POST);

if (isset($_POST["id"]) && isset($_POST["newStatus"])) {
	$reservationId = $_POST["id"];
	$newStatus = $_POST["newStatus"];

	$queryRentStatuses = "SELECT `id` FROM `rent_statuses` WHERE `name` = '$newStatus'";
	$newStatusId = mysqli_fetch_all(mysqli_query($conn, $queryRentStatuses), MYSQLI_ASSOC)[0]["id"];

	// Change the selected reservation's dates
	$queryUserType = "UPDATE reservations SET rent_status = ? WHERE id = ?";
	$stmt = mysqli_prepare($conn, $queryUserType);
	mysqli_stmt_bind_param($stmt, 'ii', $newStatusId, $reservationId);
	mysqli_stmt_execute($stmt);

	echo "success";
} else {
	echo "Post vars not set";
}

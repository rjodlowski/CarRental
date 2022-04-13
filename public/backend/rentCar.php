<?php
// session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST["reservationId"]) && isset($_POST["oldStatus"])) {
	$reservationId = $_POST["reservationId"];
	$oldStatus = $_POST["oldStatus"];

	if ($oldStatus == 1) {
		$queryRent = "UPDATE reservations SET rent_status = ? WHERE id = ?";
		$stmt = mysqli_prepare($conn, $queryRent);
		$newStatus = 2;
		mysqli_stmt_bind_param($stmt, 'ii', $newStatus, $reservationId);
		mysqli_stmt_execute($stmt);
	} else {
		// return car -> delete record
		$queryRentDel = "DELETE FROM reservations WHERE id = ?";
		$stmt = mysqli_prepare($conn, $queryRentDel);
		mysqli_stmt_bind_param($stmt, 'i', $reservationId);
		mysqli_stmt_execute($stmt);
	}

	echo "success";
} else {
	echo "Post vars not set";
}

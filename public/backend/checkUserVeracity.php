<?php
session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_SESSION["userId"])) {
	$userId = $_SESSION["userId"];

	$queryPasswd = "SELECT start, end FROM reservations WHERE user_id = $userId";
	$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);
	$canRent = 1;
	// print_r($result);

	if (sizeof($result) > 0) {
		for ($i = 0; $i < sizeof($result); $i++) {
			$start = date('Y-m-d H:i:s', strtotime($result[$i]["start"]));
			$end = date('Y-m-d H:i:s', strtotime($result[$i]["end"]));

			if ($start > $end) {
				$canRent = 0;
				$queryUpdate = "UPDATE `users` SET `can_rent_car` = ? WHERE `id` = ?";
				$stmt = mysqli_prepare($conn, $queryUpdate);
				mysqli_stmt_bind_param($stmt, 'ii', $canRent, $userId);
				mysqli_stmt_execute($stmt);
				break;
			}
		}
	}
	// print_r($reult);

	echo json_encode($canRent);
} else {
	echo "userId not set";
}

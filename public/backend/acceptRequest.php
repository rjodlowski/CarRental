<?php

// CREATE EVENT test_event_03
// ON SCHEDULE EVERY 1 MINUTE
// STARTS CURRENT_TIMESTAMP
// ENDS CURRENT_TIMESTAMP + INTERVAL 1 HOUR
// DO
//    UPDATE reservations
//    SET start = DATE(start - 1);
// SET GLOBAL event_scheduler=OFF

session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

print_r($_POST);
print_r($_SESSION);

if (isset($_POST["queueId"])) {
	if (isset($_SESSION["userId"])) {
		$queueId = $_POST["queueId"];
		$userId = $_SESSION["userId"];

		// get the queue record and accept it
		//// move to the reservations table with reservation status 1
		$queryRentStatuses = "SELECT * FROM `queue` WHERE `id` = '$queueId'";
		$queueRecord = mysqli_fetch_all(mysqli_query($conn, $queryRentStatuses), MYSQLI_ASSOC)[0];
		print_r($queueRecord);
		// queueRecord has accepted car id

		if ($queueRecord["decision"] != 2) { // Decision is not rejected
			// Remove from queue (add ot reservations)
			$queryDelete = "DELETE FROM `queue` WHERE `id` = ?";
			$stmt = mysqli_prepare($conn, $queryDelete);
			mysqli_stmt_bind_param($stmt, 'i', $queueId);
			mysqli_stmt_execute($stmt);

			$carId = $queueRecord["car_id"];
			// get all records on the same car in the queue and decline them
			$querySimilar = "SELECT * FROM `queue` WHERE `car_id` = $carId";
			$resultSimilar = mysqli_fetch_all(mysqli_query($conn, $querySimilar), MYSQLI_ASSOC);
			print_r($resultSimilar);

			$size = sizeof($resultSimilar);
			if ($size > 0) {
				for ($i = 0; $i < $size; $i++) {
					$idToDelete = $resultSimilar[$i]["id"];
					$queryUpdate = "UPDATE `queue` SET `decision` = ? WHERE `id` = ?";
					$stmt = mysqli_prepare($conn, $queryUpdate);
					$decisionDeclined = 2;
					mysqli_stmt_bind_param($stmt, 'ii', $decisionDeclined, $idToDelete);
					mysqli_stmt_execute($stmt);
				}
			}

			// TODO Update car table => status and wanted_by
			$lessWanting = sizeof($resultSimilar) + 1;
			$statusUnavailable = 3;
			$queryUpdate = "UPDATE `cars` SET `status` = ?, `wanted_by` = `wanted_by` - ? WHERE `id` = ?";
			$stmt = mysqli_prepare($conn, $queryUpdate);
			mysqli_stmt_bind_param($stmt, 'iii', $statusUnavailable, $lessWanting, $carId);
			mysqli_stmt_execute($stmt);

			echo "success";
		}
	}
} else {
	echo "Post vars not set";
}

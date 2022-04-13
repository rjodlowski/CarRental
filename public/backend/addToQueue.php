<?php
session_start();
require_once("DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// print_r($_SESSION);

if (isset($_SESSION["userId"])) {
	if (isset($_POST["start"]) && isset($_POST["end"])) {
		$userId = $_SESSION["userId"];
		$carId = $_POST["id"];
		$start = $_POST["start"];
		$end = $_POST["end"];

		// Check if user doesn't have a reservation for this car
		$existingRecordQ = "SELECT * FROM queue WHERE user_id = $userId AND car_id = $carId";
		$result = mysqli_fetch_all(mysqli_query($conn, $existingRecordQ), MYSQLI_ASSOC);

		// Check the car
		$getCounterQ = "SELECT status, wanted_by FROM cars WHERE id = $carId";
		$wantedCar = mysqli_fetch_all(mysqli_query($conn, $getCounterQ), MYSQLI_ASSOC)[0];
		$wantedBy = $wantedCar["wanted_by"];
		$oldStatus = $wantedCar["status"];
		$decision = 3;

		if ($oldStatus != 3) {
			if (sizeof($result) == 0) {
				// Add new queue record
				$query = "INSERT INTO queue(user_id, car_id, start, end, decision) VALUES (?, ?, ?, ?, ?)";
				$stmt = mysqli_prepare($conn, $query);
				mysqli_stmt_bind_param($stmt, 'ssssi', $userId, $carId, $start, $end, $decision);
				mysqli_stmt_execute($stmt);

				// Update car
				$wantedBy++;
				$newStatus = 2;

				$counterUpdateQ = "UPDATE cars SET wanted_by = ?, status = ? WHERE id = ?";
				$stmt2 = mysqli_prepare($conn, $counterUpdateQ);
				mysqli_stmt_bind_param($stmt2, 'iii', $wantedBy, $newStatus, $carId);
				mysqli_stmt_execute($stmt2);

				echo "success";
			} else {
				// User has submitted a reservation request for this car
				echo "record exists";
			}
		} else {
			echo "car taken";
		}
	} else {
		echo "Post vars not set";
	}
} else {
	echo "session vars not set";
}

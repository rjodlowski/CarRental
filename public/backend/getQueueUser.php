<?php
session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_SESSION["userId"])) {
	$userId = $_SESSION["userId"];

	$queryPasswd = "SELECT queue.id, cars.brand, cars.model, cars.price_per_hour, queue.start, queue.end FROM queue JOIN cars on queue.car_id = cars.id WHERE queue.user_id = $userId";
	$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);

	// print_r($reult);

	echo json_encode($result);
} else {
	echo "userId not set";
}

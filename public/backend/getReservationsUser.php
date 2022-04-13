<?php
session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_SESSION["userId"])) {
	$userId = $_SESSION["userId"];

	$queryPasswd = "SELECT reservations.id, cars.brand, cars.model, cars.price_per_hour, cars.image, reservations.start, reservations.end, reservations.rent_status FROM reservations JOIN cars on reservations.car_id = cars.id WHERE reservations.user_id = $userId";
	$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);

	// print_r($reult);

	echo json_encode($result);
} else {
	echo "userId not set";
}

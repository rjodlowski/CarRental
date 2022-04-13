<?php
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST["id"])) {
	$id = $_POST["id"];

	$queryReservation = "SELECT reservations.id, cars.brand, cars.model, cars.price_per_hour, cars.image, reservations.start, reservations.end, rent_statuses.name AS rent_status FROM reservations JOIN cars on reservations.car_id = cars.id JOIN rent_statuses ON rent_statuses.id = reservations.rent_status WHERE reservations.id = $id";
	$result = mysqli_fetch_all(mysqli_query($conn, $queryReservation), MYSQLI_ASSOC)[0];

	// print_r($reult);

	echo json_encode($result);
} else {
	echo "no id set";
}

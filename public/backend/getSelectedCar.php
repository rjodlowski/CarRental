<?php
session_start();
include_once("./DB.php");

if (isset($_POST["id"])) {
	$id = $_POST["id"];

	$queryPasswd = "SELECT cars.id, cars.brand, cars.model, cars.price_per_hour, cars.wanted_by, cars.image, statuses.status FROM cars JOIN statuses ON cars.status = statuses.id WHERE cars.id = $id";
	$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);

	if (sizeof($result) > 0) {
		$car = $result[0];
		// print_r($car);
		echo json_encode($car);
	} else {
		echo "no car found";
	}
} else {
	echo "no id set";
}

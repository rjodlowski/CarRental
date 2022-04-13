<?php
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// print_r($_POST);
if (isset($_POST["username"]) && isset($_POST["password"])) {
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	$type = "3";
	$canRentCar = 1;

	// Query preparation
	$query = "INSERT INTO users(type, username, password, can_rent_car) VALUES (?, ?, ?, ?)";
	$stmt = mysqli_prepare($conn, $query);

	// Query execution
	mysqli_stmt_bind_param($stmt, 'ssss', $type, $username, $password, $canRentCar);
	mysqli_stmt_execute($stmt);

	echo "success";
} else {
	echo "no data";
}

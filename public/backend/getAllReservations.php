<?php
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$queryAllReservations = "SELECT reservations.id, cars.brand, cars.model, cars.price_per_hour, cars.image, reservations.start, reservations.end FROM reservations JOIN cars on reservations.car_id = cars.id";
$result = mysqli_fetch_all(mysqli_query($conn, $queryAllReservations), MYSQLI_ASSOC);

// print_r($reult);

echo json_encode($result);

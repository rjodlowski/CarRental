<?php
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$queryPasswd = "SELECT cars.id, cars.brand, cars.model, cars.price_per_hour, statuses.status, cars.image FROM cars JOIN statuses ON cars.status = statuses.id";
$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);

// print_r($reult);

echo json_encode($result);

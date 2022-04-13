<?php
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$queryPasswd = "SELECT queue.id, cars.brand, cars.model, cars.price_per_hour, cars.image, queue.start, queue.end, decisions.name FROM queue JOIN cars on queue.car_id = cars.id JOIN decisions on decisions.id = queue.decision";
$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);


echo json_encode($result);

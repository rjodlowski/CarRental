<?php
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$queryPasswd = "SELECT * FROM rent_statuses";
$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);

echo json_encode($result);

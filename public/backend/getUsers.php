<?php
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$queryPasswd = "SELECT users.id, users.username, user_types.type FROM users JOIN user_types on users.type = user_types.id";
$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);

echo json_encode($result);

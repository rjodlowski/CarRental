<?php
session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

print_r($_POST);
print_r($_SESSION);

if (isset($_POST["queueId"])) {
	if (isset($_SESSION["userId"])) {
		$queueId = $_POST["queueId"];
		$userId = $_SESSION["userId"];

		$queryUpdate = "UPDATE `queue` SET `decision` = ? WHERE `id` = ?";
		$stmt = mysqli_prepare($conn, $queryUpdate);
		$decisionDeclined = 2;
		mysqli_stmt_bind_param($stmt, 'ii', $decisionDeclined, $queueId);
		mysqli_stmt_execute($stmt);
	}
} else {
	echo "Post vars not set";
}

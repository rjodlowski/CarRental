<?php
// session_start();
include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// print_r($_POST);

if (isset($_POST["id"]) && isset($_POST["newType"])) {
	$userId = $_POST["id"];
	$newType = $_POST["newType"];

	// Get new type id
	$queryType = "SELECT `id` FROM `user_types` WHERE `type` = '$newType'";
	$newTypeId = mysqli_fetch_all(mysqli_query($conn, $queryType), MYSQLI_ASSOC)[0]["id"];

	// print_r($newTypeId);

	// Change the selected user's type
	$queryUserType = "UPDATE `users` SET `type` = ? WHERE `users`.`id` = ?";
	$stmt = mysqli_prepare($conn, $queryUserType);
	mysqli_stmt_bind_param($stmt, 'ii', $newTypeId, $userId);
	mysqli_stmt_execute($stmt);

	echo "success";
} else {
	echo "Post vars not set";
}

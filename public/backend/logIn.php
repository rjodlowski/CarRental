<?php
// print_r($_POST);
session_start();

include_once("./DB.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$givenUsername = $_POST["username"];
$givenPasswd = md5($_POST["password"]);
// $_SESSION["loggedIn"] = 0;

$queryPasswd = "SELECT password FROM users WHERE username='$givenUsername'";
$result = mysqli_fetch_all(mysqli_query($conn, $queryPasswd), MYSQLI_ASSOC);
if (!empty($result)) {
	$dbPasswd = $result[0]['password'];

	if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] == 0) {
		if ($givenPasswd == $dbPasswd) {
			$_SESSION["username"] = $givenUsername;
			$_SESSION["loggedIn"] = 1;

			$queryId = "SELECT users.id, user_types.type, users.can_rent_car FROM users JOIN user_types ON users.type = user_types.id WHERE username='$givenUsername'";
			$result = mysqli_fetch_all(mysqli_query($conn, $queryId), MYSQLI_ASSOC)[0];
			// print_r($result);
			$_SESSION['userId'] = $result["id"];
			$_SESSION['userType'] = $result["type"];
			$_SESSION["can_rent_car"] = $result["can_rent_car"];

			echo "success";
		} else {
			echo "wrong password";
		}
	} else {
		echo "already logged in";
	}
} else {
	echo "user doesn't exist";
}

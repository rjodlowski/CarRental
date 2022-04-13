<?php
session_start();
include_once("./DB.php");

$res = array();

if (isset($_SESSION["loggedIn"])) {
	$res["loggedIn"] = $_SESSION["loggedIn"];

	if (isset($_SESSION["userType"])) {
		$res["userType"] = $_SESSION["userType"];

		if (isset($_SESSION["can_rent_car"])) {
			$res["can_rent_car"] = $_SESSION["can_rent_car"];
		} else {

			$res["can_rent_car"] = 0;
		}
	} else {
		$res["userType"] = "null";
	}
} else {
	$res["loggedIn"] = 0;
}

echo json_encode($res, true);
// echo json_encode($_SESSION, true);

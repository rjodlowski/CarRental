<?php
session_start();
session_destroy();

// if (
// 	isset($_SESSION["username"]) &&
// 	isset($_SESSION["loggedIn"]) &&
// 	isset($_SESSION["userId"]) &&
// 	isset($_SESSION["userType"])
// ) {
// 	$_SESSION["username"] = null;
// 	$_SESSION["loggedIn"] = 0;
// 	$_SESSION["userId"] = null;
// 	$_SESSION["userType"] = null;
// 	echo "Session ended";
// }

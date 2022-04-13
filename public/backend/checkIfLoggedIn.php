<?php
session_start();
if (isset($_SESSION["loggedIn"])) {
	if ($_SESSION["loggedIn"] == 1) {
		echo "logged in";
	} else {
		echo "not logged in";
	}
} else {
	echo "not logged in";
}

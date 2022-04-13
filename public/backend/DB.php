<?php

$user = "root";
$pass = "";
$hostname = "localhost";
$dbname = "projekt_samochody";

$conn = mysqli_connect($hostname, $user, $pass, $dbname) or die("Connection failed");

<?php

include_once("./DB.php");

$query = "SELECT * FROM samochody;";
$result = mysqli_query($conn, $query);
$res = array();
while ($row = mysqli_fetch_assoc($result)) {
    $res[] = $row;
}

echo (json_encode($res));

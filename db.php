<?php
// Connecting to mysql db

$host = "localhost";
$user = "root";
$password = "admin";
$db = "infs3202";
// $mysqli = new mysqli($host, $user, $pass, $db) or die($mysqli->error);

$mysqli = new mysqli("localhost", "root","admin", "accounts");
if (!$mysqli) {
    die('Could not connect: ' . mysqli_connect_error());
}
?>
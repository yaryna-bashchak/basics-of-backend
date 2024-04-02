<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "apartment_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection not established: " . $conn->connect_error);
}

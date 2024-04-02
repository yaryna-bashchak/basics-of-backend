<?php
$servername = "localhost";
$username = "admin";
$password = "admin";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection not established: " . $conn->connect_error);
}

$sql = "CREATE DATABASE apartment_db";
try {
    $conn->query($sql);
    echo "DataBase created!";
} catch (Exception $e) {
    echo "DataBase not created: " . $e->getMessage();
}

$conn->close();

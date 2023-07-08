<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Sahyogi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->error);
}

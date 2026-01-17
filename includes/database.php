<?php
/**
 * Database Configuration
 * Hotel Shayogi Reservation System
 * 
 * This is the central database configuration file.
 * All database connections throughout the application use this file.
 */

// Database configuration constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Sahyogi');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset to utf8 for proper character encoding
$conn->set_charset("utf8");

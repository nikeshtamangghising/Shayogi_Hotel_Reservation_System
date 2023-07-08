<?php
// Database connection setup
include 'db.php';
// Retrieve username and password from the form
$Username = $_POST['Username'];
$normal_Password = $_POST['Password'];

// Hash the password
$Password = sha1($normal_Password);

// Check if the provided username and password match the database
$query = "SELECT * FROM accounts WHERE Username = '$Username' AND Password = '$Password'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Authentication successful
    echo "Success";
} else {
    echo "Warning: Unknown User Trying To Acess";
}

$conn->close();

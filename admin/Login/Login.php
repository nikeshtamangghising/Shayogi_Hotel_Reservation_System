<?php
// Database connection setup
include 'db.php';
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to user

// Retrieve username and password from form
$Username = isset($_POST['Username']) ? trim($_POST['Username']) : '';
$normal_Password = isset($_POST['Password']) ? trim($_POST['Password']) : '';

// Validate inputs
if (empty($Username) || empty($normal_Password)) {
    echo "Warning: Username and password are required";
    exit;
}

// Hash password
$Password = sha1($normal_Password);

// Check if provided username and password match database
$query = "SELECT * FROM accounts WHERE Username = '$Username' AND Password = '$Password'";
$result = $conn->query($query);

if ($result && $result->num_rows == 1) {
    // Authentication successful - set session variables
    $user = $result->fetch_assoc();
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $user['Username'];
    $_SESSION['admin_user_id'] = $user['id'];
    $_SESSION['login_time'] = time();
    
    echo "Success";
} else {
    // Authentication failed
    echo "Warning: Invalid username or password";
}

$conn->close();
?>

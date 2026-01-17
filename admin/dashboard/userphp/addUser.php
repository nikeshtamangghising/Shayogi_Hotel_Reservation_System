<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Get POST data
$name = $_POST['Name'] ?? '';
$username = $_POST['Username'] ?? '';
$email = $_POST['Email'] ?? '';
$password = $_POST['Password'] ?? '';

// Validate required fields
if (empty($name) || empty($username) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Validate password length
if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long']);
    exit;
}

// Hash password
$hashedPassword = sha1($password);

try {
    // Insert user
    $sql = "INSERT INTO accounts (Name, Username, Email, Password, role) VALUES (?, ?, ?, ?, 'user')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $email, $hashedPassword);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error adding user: " . mysqli_error($conn));
    }
    
    echo json_encode(['success' => true, 'message' => 'User added successfully!']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

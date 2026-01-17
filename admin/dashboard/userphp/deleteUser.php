<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Get POST data
$userId = $_POST['ID'] ?? '';

// Validate required fields
if (empty($userId)) {
    echo json_encode(['success' => false, 'message' => 'User ID is required']);
    exit;
}

try {
    // Delete user
    $sql = "DELETE FROM accounts WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error deleting user: " . mysqli_error($conn));
    }
    
    echo json_encode(['success' => true, 'message' => 'User deleted successfully!']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

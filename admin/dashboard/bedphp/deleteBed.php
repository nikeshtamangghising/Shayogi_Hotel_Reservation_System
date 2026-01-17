<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Get POST data
$bedId = $_POST['ID'] ?? '';

// Validate required fields
if (empty($bedId)) {
    echo json_encode(['success' => false, 'message' => 'Bed ID is required']);
    exit;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Delete bed type
    $sql = "DELETE FROM BedTypes WHERE BedTypeId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bedId);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error deleting bed: " . mysqli_error($conn));
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo json_encode(['success' => true, 'message' => 'Bed deleted successfully!']);
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

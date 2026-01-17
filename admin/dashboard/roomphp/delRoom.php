<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Get POST data
$roomId = $_POST['ID'] ?? '';

// Validate required fields
if (empty($roomId)) {
    echo json_encode(['success' => false, 'message' => 'Room ID is required']);
    exit;
}

// Check if room has existing reservations
$checkSql = "SELECT COUNT(*) as reservation_count FROM Reservations WHERE RoomID = ?";
$checkStmt = mysqli_prepare($conn, $checkSql);
mysqli_stmt_bind_param($checkStmt, "i", $roomId);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);
$reservationCount = mysqli_fetch_assoc($checkResult)['reservation_count'];

if ($reservationCount > 0) {
    echo json_encode(['success' => false, 'message' => 'Cannot delete room: It has ' . $reservationCount . ' existing reservation(s). Please cancel reservations first.']);
    exit;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Delete bed types first
    $bedSql = "DELETE FROM BedTypes WHERE RoomId = ?";
    $bedStmt = mysqli_prepare($conn, $bedSql);
    mysqli_stmt_bind_param($bedStmt, "i", $roomId);
    mysqli_stmt_execute($bedStmt);
    
    // Delete room
    $sql = "DELETE FROM Rooms WHERE RoomId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $roomId);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error deleting room: " . mysqli_error($conn));
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo json_encode(['success' => true, 'message' => 'Room deleted successfully!']);
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

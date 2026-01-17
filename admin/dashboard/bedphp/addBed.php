<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Get POST data
$roomId = $_POST['roomId'] ?? '';
$bedtype = $_POST['bedtype'] ?? '';
$numberofbeds = $_POST['numberofbeds'] ?? 1;

// Validate required fields
if (empty($roomId) || empty($bedtype)) {
    echo json_encode(['success' => false, 'message' => 'Room ID and Bed Type are required']);
    exit;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Insert bed type
    $sql = "INSERT INTO BedTypes (RoomId, BedType, NumberOfBeds) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $roomId, $bedtype, $numberofbeds);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error adding bed: " . mysqli_error($conn));
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo json_encode(['success' => true, 'message' => 'Bed added successfully!']);
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Check database connection
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Get POST data
$customname = $_POST['customname'] ?? '';
$roomtype = $_POST['roomtype'] ?? '';
$bedtype = $_POST['bedtype'] ?? '';
$price = $_POST['price'] ?? '';
$numberofbeds = $_POST['numberofbeds'] ?? 1;
$totaloccupancy = $_POST['totaloccupancy'] ?? 1;
$attachbathroom = isset($_POST['attachbathroom']) ? 1 : 0;
$nonsmokingroom = isset($_POST['nonsmokingroom']) ? 1 : 0;

// Validate required fields
if (empty($customname) || empty($roomtype) || empty($price)) {
    echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
    exit;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Insert room
    $sql = "INSERT INTO Rooms (CustomNo, RoomType, RoomName, AttachBathroom, NonSmokingRoom, Price, TotalOccupancy) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssiiis", $customname, $roomtype, $roomtype, $attachbathroom, $nonsmokingroom, $price, $totaloccupancy);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error adding room: " . mysqli_error($conn));
    }
    
    $roomId = mysqli_insert_id($conn);
    
    // Insert bed type if provided
    if (!empty($bedtype)) {
        $bedSql = "INSERT INTO BedTypes (RoomId, BedType, NumberOfBeds) VALUES (?, ?, ?)";
        $bedStmt = mysqli_prepare($conn, $bedSql);
        mysqli_stmt_bind_param($bedStmt, "isi", $roomId, $bedtype, $numberofbeds);
        
        if (!mysqli_stmt_execute($bedStmt)) {
            throw new Exception("Error adding bed type: " . mysqli_error($conn));
        }
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo json_encode(['success' => true, 'message' => 'Room added successfully!']);
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

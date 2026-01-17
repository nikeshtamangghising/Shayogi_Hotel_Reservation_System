<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Get POST data
$roomId = $_POST['roomId'] ?? '';
$customname = $_POST['customname'] ?? '';
$roomtype = $_POST['roomtype'] ?? '';
$bedtype = $_POST['bedtype'] ?? '';
$price = $_POST['price'] ?? '';
$numberofbeds = $_POST['numberofbeds'] ?? 1;
$totaloccupancy = $_POST['totaloccupancy'] ?? 1;
$attachbathroom = isset($_POST['attachbathroom']) ? 1 : 0;
$nonsmokingroom = isset($_POST['nonsmokingroom']) ? 1 : 0;

// Validate required fields
if (empty($roomId) || empty($customname) || empty($roomtype) || empty($price)) {
    echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
    exit;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Update room
    $sql = "UPDATE Rooms SET CustomNo = ?, RoomType = ?, RoomName = ?, AttachBathroom = ?, NonSmokingRoom = ?, Price = ?, TotalOccupancy = ? WHERE RoomId = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssiiisi", $customname, $roomtype, $roomtype, $attachbathroom, $nonsmokingroom, $price, $totaloccupancy, $roomId);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error updating room: " . mysqli_error($conn));
    }
    
    // Update or insert bed type if provided
    if (!empty($bedtype)) {
        // Check if bed type exists
        $checkSql = "SELECT BedTypeId FROM BedTypes WHERE RoomId = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "i", $roomId);
        mysqli_stmt_execute($checkStmt);
        $result = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Update existing bed type instead of inserting
            $bedSql = "UPDATE BedTypes SET BedType = ?, NumberOfBeds = ? WHERE RoomId = ?";
            $bedStmt = mysqli_prepare($conn, $bedSql);
            mysqli_stmt_bind_param($bedStmt, "sii", $bedtype, $numberofbeds, $roomId);
        } else {
            // Insert new bed type
            $bedSql = "INSERT INTO BedTypes (RoomId, BedType, NumberOfBeds) VALUES (?, ?, ?)";
            $bedStmt = mysqli_prepare($conn, $bedSql);
            mysqli_stmt_bind_param($bedStmt, "isi", $roomId, $bedtype, $numberofbeds);
        }
        
        if (!mysqli_stmt_execute($bedStmt)) {
            throw new Exception("Error updating bed type: " . mysqli_error($conn));
        }
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo json_encode(['success' => true, 'message' => 'Room updated successfully!']);
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

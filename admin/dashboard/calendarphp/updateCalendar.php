<?php
// Database connection setup
include '../../../php/db.php';

header('Content-Type: application/json');

// Get POST data
$room = $_POST['room'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$availableRooms = $_POST['availableRooms'] ?? 1;

// Validate required fields
if (empty($room) || empty($startDate) || empty($endDate)) {
    echo json_encode(['success' => false, 'message' => 'Room, Start Date, and End Date are required']);
    exit;
}

// Validate date range
if ($startDate > $endDate) {
    echo json_encode(['success' => false, 'message' => 'Start date must be before or equal to end date']);
    exit;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Generate date range
    $dates = array();
    $current = new DateTime($startDate);
    $end = new DateTime($endDate);
    
    while ($current <= $end) {
        $dates[] = $current->format('Y-m-d');
        $current->modify('+1 day');
    }
    
    $updatedCount = 0;
    $insertedCount = 0;
    
    foreach ($dates as $date) {
        // Check if calendar entry exists for this date and room
        $checkSql = "SELECT DateID FROM Calendar WHERE Date = ? AND RoomId = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);
        
        if (!$checkStmt) {
            throw new Exception("Error preparing check statement: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($checkStmt, "si", $date, $room);
        mysqli_stmt_execute($checkStmt);
        $result = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Update existing entry
            $sql = "UPDATE Calendar SET Availabilities = ? WHERE Date = ? AND RoomId = ?";
            $stmt = mysqli_prepare($conn, $sql);
            
            if (!$stmt) {
                throw new Exception("Error preparing update statement: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt, "isi", $availableRooms, $date, $room);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error updating calendar: " . mysqli_error($conn));
            }
            $updatedCount++;
        } else {
            // Insert new entry
            $sql = "INSERT INTO Calendar (Date, RoomId, Availabilities) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            
            if (!$stmt) {
                throw new Exception("Error preparing insert statement: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt, "sii", $date, $room, $availableRooms);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error adding calendar entry: " . mysqli_error($conn));
            }
            $insertedCount++;
        }
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    $message = "Calendar updated successfully! ";
    if ($updatedCount > 0) $message .= "Updated $updatedCount existing entries. ";
    if ($insertedCount > 0) $message .= "Added $insertedCount new entries. ";
    $message .= "Total dates processed: " . count($dates);
    
    echo json_encode(['success' => true, 'message' => $message]);
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

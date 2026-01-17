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
$room = $_POST['room'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$availableRooms = $_POST['availableRooms'] ?? 1;
$status = $_POST['status'] ?? '';

// Validate required fields
if (empty($room) || empty($startDate) || empty($endDate) || empty($status)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate date range
if ($startDate > $endDate) {
    echo json_encode(['success' => false, 'message' => 'Start date must be before or equal to end date']);
    exit;
}

try {
    // Test with just one date first
    $testDate = $startDate;
    
    // Check if calendar entry exists
    $checkSql = "SELECT CalendarId FROM Calendar WHERE Date = '$testDate' AND RoomID = $room";
    $result = mysqli_query($conn, $checkSql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Update existing entry
        $sql = "UPDATE Calendar SET AvailableRooms = $availableRooms, Status = '$status' WHERE Date = '$testDate' AND RoomID = $room";
        $updateResult = mysqli_query($conn, $sql);
        
        if ($updateResult) {
            echo json_encode(['success' => true, 'message' => 'Calendar entry updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed: ' . mysqli_error($conn)]);
        }
    } else {
        // Insert new entry
        $sql = "INSERT INTO Calendar (Date, RoomID, AvailableRooms, Status) VALUES ('$testDate', $room, $availableRooms, '$status')";
        $insertResult = mysqli_query($conn, $sql);
        
        if ($insertResult) {
            echo json_encode(['success' => true, 'message' => 'Calendar entry added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Insert failed: ' . mysqli_error($conn)]);
        }
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>

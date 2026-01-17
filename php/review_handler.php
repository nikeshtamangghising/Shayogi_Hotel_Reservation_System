<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];

if ($_POST['action'] === 'submit_review') {
    $reservationId = $_POST['reservation_id'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $reviewText = $_POST['review_text'] ?? '';
    
    if (empty($rating) || empty($reviewText)) {
        echo json_encode(['success' => false, 'message' => 'Rating and review text are required']);
        exit;
    }
    
    // Verify this reservation belongs to the user
    $checkSql = "SELECT r.ReservationID, rm.RoomName 
                 FROM reservations r 
                 LEFT JOIN Rooms rm ON r.RoomID = rm.RoomId 
                 WHERE r.ReservationID = ? AND r.GuestID = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "ii", $reservationId, $userId);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);
    
    if (mysqli_num_rows($checkResult) === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid reservation']);
        exit;
    }
    
    // Update the Review column in Guests table with the new review
    $updateSql = "UPDATE Guests SET Review = ? WHERE GuestID = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "si", $reviewText, $userId);
    
    if (mysqli_stmt_execute($updateStmt)) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit review']);
    }
}
?>

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

// Get user reviews from Guests table Review column
$sql = "SELECT 
            g.Review as review_text,
            g.FullName as guest_name,
            5 as rating,
            NOW() as date
        FROM Guests g
        WHERE g.GuestID = ?
        AND g.Review IS NOT NULL AND g.Review != ''";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$reviews = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = [
        'review_text' => $row['review_text'],
        'rating' => $row['rating'],
        'room_name' => 'Hotel Stay',
        'date' => date('M d, Y', strtotime($row['date']))
    ];
}

echo json_encode([
    'success' => true,
    'reviews' => $reviews
]);
?>

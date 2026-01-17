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

// Get user bookings from reservations table
$sql = "SELECT 
            r.ReservationID,
            r.RoomID,
            r.CheckInDate,
            r.CheckOutDate,
            r.NumAdults + r.NumChildren as guests,
            r.Stay as total_price,
            rm.RoomName as room_name,
            rm.RoomType as room_type,
            rm.Price as price,
            CASE 
                WHEN r.CheckInDate <= CURDATE() THEN 'confirmed'
                ELSE 'pending'
            END as status
        FROM reservations r
        LEFT JOIN Rooms rm ON r.RoomID = rm.RoomId
        WHERE r.GuestID = ?
        ORDER BY r.CheckInDate DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = [
        'reservation_id' => $row['ReservationID'],
        'room_name' => $row['room_name'] ?? 'Room',
        'room_type' => $row['room_type'] ?? 'Standard',
        'check_in' => date('M d, Y', strtotime($row['CheckInDate'])),
        'check_out' => date('M d, Y', strtotime($row['CheckOutDate'])),
        'guests' => $row['guests'],
        'total_price' => number_format($row['total_price'], 2),
        'status' => $row['status'] ?? 'confirmed'
    ];
}

echo json_encode([
    'success' => true,
    'bookings' => $bookings
]);
?>

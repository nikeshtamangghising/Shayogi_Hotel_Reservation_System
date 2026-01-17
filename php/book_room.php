<?php
// Handle room booking with user authentication
require_once 'db.php';
require_once 'user_auth.php';

$auth = new UserAuth();

// Check if user is logged in
if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to book a room']);
    exit;
}

// Get the POST data
$roomID = mysqli_real_escape_string($conn, $_POST['roomId']);
$checkIn = mysqli_real_escape_string($conn, $_POST['checkInDate']);
$checkOut = mysqli_real_escape_string($conn, $_POST['checkOutDate']);
$fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
$email = mysqli_real_escape_string($conn, $_POST['guestEmail']);
$phone = mysqli_real_escape_string($conn, $_POST['guestPhone']);
$verifyID = mysqli_real_escape_string($conn, $_POST['guestVerifyID']);
$country = mysqli_real_escape_string($conn, $_POST['guestCountry']);
$numberGuest = mysqli_real_escape_string($conn, $_POST['numberGuest']);

// Validate required fields
if (empty($roomID) || empty($checkIn) || empty($checkOut) || empty($fullName) || empty($email) || empty($phone) || empty($verifyID) || empty($country) || empty($numberGuest)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate date format
if (!strtotime($checkIn) || !strtotime($checkOut)) {
    echo json_encode(['success' => false, 'message' => 'Invalid date format']);
    exit;
}

// Ensure check-in is before check-out
if (strtotime($checkIn) >= strtotime($checkOut)) {
    echo json_encode(['success' => false, 'message' => 'Check-in date must be before check-out date']);
    exit;
}

// Check if the room is available
$sql = "SELECT * FROM calendar WHERE RoomId = '$roomID' AND (Date >= '$checkIn' AND Date < '$checkOut')";
$result = mysqli_query($conn, $sql);

$availableRooms = array();
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Availabilities'] > 0) {
        $availableRooms[] = $row;
    } else {
        // Room is not available for one of the dates
        echo json_encode(['success' => false, 'message' => 'Room not available for selected dates. Please try different dates.']);
        exit;
    }
}

// If the room is available, update the calendar table
if (count($availableRooms) > 0) {
    // Begin transaction
    mysqli_autocommit($conn, FALSE);
    
    try {
        // Decrease the availability by 1 for each day
        $calendarsql = "UPDATE calendar
                SET Availabilities = Availabilities - 1
                WHERE RoomId = '$roomID'
                AND Date >= '$checkIn'
                AND Date < '$checkOut'";

        if (!mysqli_query($conn, $calendarsql)) {
            throw new Exception("Failed to update calendar");
        }

        // Insert guest details into Guests table
        $insertGuestQuery = "INSERT INTO guests (FullName, Phone, ID_Verification, Country, Email) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertGuestQuery);
        mysqli_stmt_bind_param($stmt, "sssss", $fullName, $phone, $verifyID, $country, $email);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to insert guest details");
        }
        
        $guestID = mysqli_insert_id($conn); // Get the last inserted guest ID

        // Insert reservation details into Reservations table
        $insertReservationQuery = "INSERT INTO reservations (GuestID, RoomID, CheckInDate, CheckOutDate, NumAdults) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertReservationQuery);
        mysqli_stmt_bind_param($stmt, "iisii", $guestID, $roomID, $checkIn, $checkOut, $numberGuest);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to insert reservation details");
        }

        // Commit transaction
        mysqli_commit($conn);
        
        $response = [
            'success' => true,
            'message' => 'Room booked successfully!',
            'redirect' => '../profile.php#bookings'
        ];
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        $response = ['success' => false, 'message' => $e->getMessage()];
    }
} else {
    $response = ['success' => false, 'message' => 'Room Not Available. Try Again With Different Date And Room.'];
}

echo json_encode($response);

$conn->close();
?>
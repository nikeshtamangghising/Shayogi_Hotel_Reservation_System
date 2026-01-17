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
$clientPrice = mysqli_real_escape_string($conn, $_POST['roomPrice']); // Price sent from client

// Fetch the base price from the database to calculate dynamic price
$sql = "SELECT Price FROM Rooms WHERE RoomId = '$roomID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Room not found']);
    exit;
}

$basePrice = $row['Price'];

// Calculate the dynamic price using the same algorithm as show_rooms.php
$dynamicPrice = calculateDynamicPrice($basePrice, $roomID, $checkIn, $checkOut);

// Validate that the client-sent price matches our calculated dynamic price
$tolerance = 0.01; // Allow small floating point differences
if (abs(floatval($clientPrice) - $dynamicPrice) > $tolerance) {
    // Log the price mismatch for debugging (optional)
    error_log("Price mismatch detected: Client sent $clientPrice, calculated $dynamicPrice for Room $roomID");
    // Use the calculated dynamic price to ensure consistency
    $roomPrice = $dynamicPrice;
} else {
    // Prices match, use the client's price
    $roomPrice = $clientPrice;
}

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
        
        // Optionally, log the price used for the reservation in a separate table
        // Attempt to log the price but ignore errors if table doesn't exist
        $logPriceQuery = "INSERT INTO reservation_prices (ReservationID, Price, PriceType) VALUES (LAST_INSERT_ID(), ?, 'dynamic')";
        $stmtPrice = mysqli_prepare($conn, $logPriceQuery);
        if($stmtPrice) {
            mysqli_stmt_bind_param($stmtPrice, "s", $roomPrice);
            mysqli_stmt_execute($stmtPrice); // Execute but ignore errors if table doesn't exist
        }

        // Update the reservation with the price used if the column exists
        $updatePriceQuery = "UPDATE reservations SET ReservedPrice = ? WHERE ReservationID = LAST_INSERT_ID()";
        $stmtUpdatePrice = mysqli_prepare($conn, $updatePriceQuery);
        if($stmtUpdatePrice) {
            mysqli_stmt_bind_param($stmtUpdatePrice, "s", $roomPrice);
            mysqli_stmt_execute($stmtUpdatePrice); // Execute but ignore errors if column doesn't exist
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

/**
 * Dynamic Pricing Function
 * Calculates the same dynamic price as used in show_rooms.php
 */
function calculateDynamicPrice($basePrice, $roomId, $checkIn, $checkOut) {
    $price = floatval($basePrice);
    $multiplier = 1.0;
    
    // Factor 1: Time-based pricing (simpler version)
    $daysUntilCheckin = (strtotime($checkIn) - time()) / (24 * 60 * 60);
    if ($daysUntilCheckin <= 3) {
        $multiplier += 0.25; // Last-minute premium
    } elseif ($daysUntilCheckin <= 7) {
        $multiplier += 0.10; // Short notice
    } elseif ($daysUntilCheckin > 60) {
        $multiplier -= 0.10; // Early booking discount
    }
    
    // Factor 2: Seasonal adjustment
    $month = date('n', strtotime($checkIn));
    if (in_array($month, [10, 11, 12, 1, 2])) { // Peak tourist season
        $multiplier += 0.20; // +20%
    } elseif (in_array($month, [6, 7, 8, 9])) { // Monsoon season
        $multiplier -= 0.15; // -15%
    }
    
    // Factor 3: Room popularity adjustment
    $popularRooms = [18, 19]; // Based on sample data
    if (in_array($roomId, $popularRooms)) {
        $multiplier += 0.10; // +10% for popular rooms
    }
    
    // Apply reasonable bounds
    $multiplier = max(0.7, min(1.8, $multiplier));
    
    return round($price * $multiplier, 2);
}

?>
<?php
/**
 * Simple Dynamic Pricing Algorithm for Room Availability
 * Implements real-time price adjustment based on demand factors
 */

include 'db.php';

$checkInDate = $_POST['checkInDate'];
$checkOutDate = $_POST['checkOutDate'];
$numberGuest = $_POST['numberGuest'];

// Original query
$sql = "
 SELECT DISTINCT r.*,c.Availabilities
        FROM Rooms r
        INNER JOIN Calendar c ON r.RoomId = c.RoomId
        WHERE c.Date BETWEEN '$checkInDate' AND '$checkOutDate'
        AND r.TotalOccupancy >= '$numberGuest' AND c.Availabilities >= 1
        ORDER BY r.RoomId";

$result = mysqli_query($conn, $sql);

$availableRooms = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Simple Dynamic Pricing Algorithm
    $dynamicPrice = calculateDynamicPrice(
        $row['Price'], 
        $row['RoomId'], 
        $checkInDate, 
        $checkOutDate
    );
    
    // Add dynamic price to room data
    $row['DynamicPrice'] = $dynamicPrice;
    $row['PriceDifference'] = round($dynamicPrice - $row['Price'], 2);
    $row['PriceChangePercent'] = round((($dynamicPrice - $row['Price']) / $row['Price']) * 100, 1);
    
    $availableRooms[] = $row;
}

echo json_encode($availableRooms);

mysqli_close($conn);

/**
 * Simple Dynamic Pricing Function
 * Adjusts room prices based on availability and timing
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

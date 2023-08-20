<?php
// Database connection setup
include '../db.php'; // Make sure this points to your database connection script

$reservationQuery = "SELECT * FROM Reservations";
$reservationResult = $conn->query($reservationQuery);
$data = [];

if ($reservationResult->num_rows > 0) {
    while ($reservation = $reservationResult->fetch_assoc()) {
        $start_date = new DateTime($reservation["CheckInDate"]);
        $end_date = new DateTime($reservation["CheckOutDate"]);

        echo "Processing reservation ID: " . $reservation["ReservationID"] . "\n";

        // Update Availabilities for each date
        while ($start_date < $end_date) {
            $date = $start_date->format("Y-m-d");
            echo "Updating availability for date: " . $date . "\n";

            $updateQuery = "UPDATE Calendar SET Availabilities = Availabilities - 1 WHERE RoomId = {$reservation["RoomID"]} AND Date = '{$date}'";
            $updateResult = $conn->query($updateQuery);

            if (!$updateResult) {
                $data[] = "Error updating availability: " . mysqli_error($conn);
            }

            $start_date->modify("+1 day");
        }
    }
} else {
    $data[] = "No reservations found.";
}

$conn->close();
echo json_encode($data);

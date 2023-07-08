<?php
// Database connection setup
include 'db.php';

// Retrieve data from the form
$CustomNo = $_POST['CustomNo'];
$RoomType = $_POST['RoomType'];
$RoomName = $_POST['RoomName'];
$BedType = $_POST['BedType'];
$NumberOfBeds = $_POST['NumberOfBeds'];
$AttachBathroom = $_POST['AttachBathroom'];
$NonSmokingRoom = $_POST['NonSmokingRoom'];
$TotalOccupancy = $_POST['TotalOccupancy'];
$Price = $_POST['Price'];

// Insert room details into the Rooms table
$sql = "INSERT INTO Rooms (CustomNo, RoomType, RoomName, AttachBathroom, NonSmokingRoom, TotalOccupancy, Price) VALUES ('$CustomNo', '$RoomType', '$RoomName', '$AttachBathroom', '$NonSmokingRoom', '$TotalOccupancy', '$Price')";

if (mysqli_query($conn, $sql)) {
    $roomId = mysqli_insert_id($conn); // Get the ID of the inserted room

    // Insert bed details into the BedTypes table
    $bsql = "INSERT INTO BedTypes (RoomId, BedType, NumberOfBeds) VALUES ('$roomId', '$BedType', '$NumberOfBeds')";

    if (mysqli_query($conn, $bsql)) {
        echo "Room and Bed successfully added";
    } else {
        echo "Unable to add bed details. Please try again.";
    }
} else {
    echo "Unable to add room details. Please try again.";
}

// Close the database connection
$conn->close();

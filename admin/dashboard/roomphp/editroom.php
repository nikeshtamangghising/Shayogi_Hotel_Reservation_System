<?php
// Include the database connection setup
include '../db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve the data from the form
    $BID = $_POST['BID'];
    $ID = $_POST['ID'];
    $CustomNo = $_POST['CustomNo'];
    $RoomType = $_POST['RoomType'];
    $RoomName = $_POST['RoomName'];
    $BedType = $_POST['BedType'];
    $NumberOfBeds = $_POST['NumberOfBeds'];
    $AttachBathroom = $_POST['AttachBathroom'];
    $NonSmokingRoom = $_POST['NonSmokingRoom'];
    $TotalOccupancy = $_POST['TotalOccupancy'];
    $Price = $_POST['Price'];

    // Update the record in the database
    $sql = "UPDATE Rooms SET CustomNo = '$CustomNo', RoomType = '$RoomType', RoomName = '$RoomName', AttachBathroom = '$AttachBathroom', NonSmokingRoom = '$NonSmokingRoom', TotalOccupancy = '$TotalOccupancy', Price = '$Price' WHERE RoomId = '$ID'";
    $Bsql = "UPDATE BedTypes SET BedType = '$BedType', NumberOfBeds = '$NumberOfBeds' WHERE BedTypeId = '$BID'";

    if (mysqli_query($conn, $sql)) {
        if (mysqli_query($conn, $Bsql)) {
            echo "Room and Bed Records updated successfully";
        } else {
            echo "Error updating Bed record: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating Room record: " . mysqli_error($conn);
    }
}

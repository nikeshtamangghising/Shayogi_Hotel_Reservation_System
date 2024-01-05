<?php

// Include the database connection setup
include '../db.php';
$staff_id = $_POST['staff_id'];
$withdrawal_date = $_POST['withdrawal_date'];
$withdrawal_amount = $_POST['withdrawal_amount'];
$withdrawal_reason = $_POST['withdrawal_reason'];

$sql = "INSERT INTO Withdrawals (staff_id, withdrawal_date, withdrawal_amount, withdrawal_reason) VALUES ('$staff_id', '$withdrawal_date', '$withdrawal_amount', '$withdrawal_reason')";
if (mysqli_query($conn, $sql)) {
    // Deletion successful
    echo "Bed Add Sucessfully";
    exit;
} else {
    // Failed to delete the record
    echo "Error Unable To Add Bed";
    exit;
}
$conn->close();

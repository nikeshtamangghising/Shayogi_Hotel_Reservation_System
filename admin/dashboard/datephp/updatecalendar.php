<?php
// Database connection setup
include '../db.php';

// Make sure to sanitize and validate user inputs
$RoomId = mysqli_real_escape_string($conn, $_POST['RoomId']);
$Availability = mysqli_real_escape_string($conn, $_POST['Availability']);
$StartDate = mysqli_real_escape_string($conn, $_POST['StartDate']);
$EndDate = mysqli_real_escape_string($conn, $_POST['EndDate']);

// Calculate the number of days between StartDate and EndDate
$daysDiff = (strtotime($EndDate) - strtotime($StartDate)) / (60 * 60 * 24);

// Prepare and execute the SQL statements for variable assignment
$sql1 = "SET @RoomId = '{$RoomId}';";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "SET @DefaultAvailabilities = '{$Availability}';";
$result2 = mysqli_query($conn, $sql2);

$sql3 = "SET @StartDate = '{$StartDate}';";
$result3 = mysqli_query($conn, $sql3);

$sql4 = "SET @EndDate = '{$EndDate}';";
$result4 = mysqli_query($conn, $sql4);

// Create a temporary table to hold numbers from 0 to the calculated daysDiff
$tempTableSql = "CREATE TEMPORARY TABLE Numbers (n INT)";
$tempTableResult = mysqli_query($conn, $tempTableSql);

for ($i = 0; $i <= $daysDiff; $i++) {
    $insertNumberSql = "INSERT INTO Numbers (n) VALUES ($i)";
    mysqli_query($conn, $insertNumberSql);
}

// Insert data into the Calendar table
$insertSql = "
    INSERT INTO Calendar (RoomId, Date, Availabilities)
    SELECT
        @RoomId,
        DATE_ADD(@StartDate, INTERVAL Numbers.n DAY),
        @DefaultAvailabilities
    FROM Numbers
    WHERE DATE_ADD(@StartDate, INTERVAL Numbers.n DAY) <= @EndDate";
$insertResult = mysqli_query($conn, $insertSql);

// Check if the insertion was successful
$data = [];
if ($insertResult) {
    $data[] = "Data inserted successfully.";
} else {
    $data[] = "Error inserting data: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

// Return the result to the user
echo json_encode($data);

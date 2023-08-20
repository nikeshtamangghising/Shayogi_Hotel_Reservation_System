<?php

// Include the database connection setup
include '../db.php';
$RoomId = $_POST['ID'];
$DefaultAvailabilities = $_POST['NumberOfBeds'];
$EndDate = $_POST['BedType'];
$StartDate = $_POST['NumberOfBeds'];

$sql = "SET @StartDate = '2023-08-01';
SET @EndDate = '2023-08-08';
SET @RoomId = 18;
SET @DefaultAvailabilities = 0; -- Change this to your default value

-- Generate dates and insert into Calendar table
INSERT INTO Calendar (RoomId, Date, Availabilities)
SELECT
    @RoomId,
    DATE_ADD(@StartDate, INTERVAL Numbers.n DAY),
    @DefaultAvailabilities
FROM (
    SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
    UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
    -- ... Add more UNION ALL SELECT statements to cover the desired date range
) AS Numbers
WHERE DATE_ADD(@StartDate, INTERVAL Numbers.n DAY) <= @EndDate;
";
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

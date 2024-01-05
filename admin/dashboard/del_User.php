<?php

// Include the database connection setup
include 'db.php';
$ID = $_POST['ID'];
$rows = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM accounts WHERE ID = $ID"));
if ($rows["role"] == "admin") {
    echo "Admin Can Not Be Delete";
    exit;
} else {
    $sql = "DELETE FROM accounts WHERE ID = $ID";
    if (mysqli_query($conn, $sql)) {
        // Deletion successful
        echo "User Deleted Sucessfully";
        exit;
    } else {
        // Failed to delete the record
        echo "Error Unable To Delete";
        exit;
    }
}

$conn->close();

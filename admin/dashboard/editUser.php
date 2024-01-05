<?php
// Include the database connection setup
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve the data from the form
    $ID = $_POST['ID'];
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $nPassword = $_POST['Password'];
    $Username = $_POST['Username'];
    $Password = sha1($nPassword); // Hash the password using sha1 (Note: sha1 is not recommended for secure password hashing)

    // Check if the user is an admin (assuming 'role' is a column in the 'accounts' table)
    $result = mysqli_query($conn, "SELECT * FROM accounts WHERE ID = '$ID'");
    $row = mysqli_fetch_assoc($result);
    if ($row["role"] == "admin") {
        echo "Admin cannot be Edit";
        exit;
    }
    // Update the record in the database
    $sql = "UPDATE accounts SET Name = '$Name', Email = '$Email', Username = '$Username', Password = '$Password' WHERE ID = '$ID'";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
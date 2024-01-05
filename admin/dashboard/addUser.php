<?php
// Database connection setup
include 'db.php';

// Retrieve username and password from the form
$Name = $_POST['Name'];
$Email = $_POST['Email'];
$nPasswoord = $_POST['Password'];
$Username = $_POST['Username'];
$Password = sha1($nPasswoord);
$sql = "INSERT INTO accounts (Name, Username, Password, Email) VALUES ('$Name','$Username','$Password','$Email')";
if (mysqli_query($conn, $sql)) {
    echo "successfuly Added";
} else {
    echo "Unable To Add Please Try Again";
}
$conn->close();

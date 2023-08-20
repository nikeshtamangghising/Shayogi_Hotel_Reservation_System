<?php
// Include the database connection setup
include '../db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve the data from the form
    $staff_id = $_POST['staffID'];
    $staff_fullname = $_POST['Fullname'];
    $staff_position = $_POST['Position'];
    $staff_salary = $_POST['Salary'];
    $hire_date = $_POST['HireOn'];
    $staff_phone = $_POST['Phone'];
    $staff_email = $_POST['Email'];

    // Update the record in the database
    $sql = "UPDATE Staff SET staff_fullname = '$staff_fullname', staff_position = '$staff_position', staff_salary = '$staff_salary', hire_date = '$hire_date', staff_phone = '$staff_phone', staff_email = '$staff_email' WHERE staff_id = '$staff_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Staff Records updated successfully";
    } else {
        echo "Error updating Staff Records: " . mysqli_error($conn);
    }
}

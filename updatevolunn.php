<?php
include 'db_conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginvolunteer.php");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $freeday = isset($_POST['freeday']) ? $_POST['freeday'] : NULL;

    // Process available days
    if (isset($_POST['available_days'])) {
        $availableDays = implode(',', $_POST['available_days']);
    } else {
        $availableDays = "";
    }

    // Update query
    $update_query = "UPDATE volunteers SET fname='$fname', lname='$lname', phone='$phone', freeday='$freeday', availableday='$availableDays' WHERE username='$username'";

    // Execute update query
    if (mysqli_query($conn, $update_query)) {
        // Redirect to profile page
        header("Location: profileevolun.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Redirect if accessed directly
    header("Location: homevolun.php");
    exit();
}
?>

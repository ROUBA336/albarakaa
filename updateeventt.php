<?php
include 'db_conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginvolunteer.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Retrieve the username from the session
    $username = $_SESSION['username'];

    // Get the submitted form data
    $fooditems = isset($_POST['fooditem']) ? implode(", ", $_POST['fooditem']) : "";
    $deliverytime = $_POST['deliverytime'];
    $phone = $_POST['phone'];
    $event_id = $_POST['event_id']; // Retrieve the event ID from the form

    // Update the database with the new values, only for the row with the specified event ID
    $update_query = "UPDATE eventt SET fooditem = ?, deliverytime = ?, phone = ? WHERE eid = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $update_query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssi", $fooditems, $deliverytime, $phone, $event_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Success
        // Redirect to the home page after updating the row
        header("Location: homeevent.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>

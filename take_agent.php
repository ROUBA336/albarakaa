<?php
session_start(); // Start the session

include 'db_conn.php';

// Check if the event ID is set
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Query to get the volunteer's vid
        $volunteer_query = "SELECT vid FROM volunteers WHERE username = '$username'";
        $volunteer_result = mysqli_query($conn, $volunteer_query);

        // Check if the query was successful
        if ($volunteer_result && mysqli_num_rows($volunteer_result) > 0) {
            $volunteer = mysqli_fetch_assoc($volunteer_result);
            $vid = $volunteer['vid'];

            // Insert into the assistant table
            $insert_query = "INSERT INTO assistant (eid, vid) VALUES ($event_id, $vid)";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                // Insertion successful, redirect to previous page
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            } else {
                // Error inserting into assistant table
                echo "Error: " . mysqli_error($conn);
                exit();
            }
        } else {
            // Volunteer not found
            echo "Volunteer not found";
            exit();
        }
    } else {
        // User is not logged in, redirect to login page
        header("Location: login.php");
        exit();
    }
} else {
    // Event ID not provided
    header("Location: events.php");
    exit();
}
?>

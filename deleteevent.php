<?php
session_start();

// Include database connection
include("db_conn.php");

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: events.php");
    exit();
}

// Check if event ID is set in the URL
if (isset($_GET['id'])) {
    // Sanitize the event ID
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the event from the database
    $delete_query = mysqli_query($conn, "DELETE FROM eventt WHERE eid='$event_id'");

    if ($delete_query) {
        // Event deleted successfully, redirect back to the profile page
        header("Location: homeevent.php"); // Adjust this to your profile page URL
        exit();
    } else {
        // Error occurred while deleting the event
        echo "Error deleting event.";
    }
} else {
    // If event ID is not set in the URL, redirect to the profile page
    header("Location: homeevent.php"); // Adjust this to your profile page URL
    exit();
}
?>

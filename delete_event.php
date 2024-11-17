<?php
// Database connection
include 'db_conn.php';

// Check if event_id is set and not empty
if (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
    // Sanitize the event_id to prevent SQL injection
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);

    // SQL query to delete event
    $sql = "DELETE FROM eventt WHERE eid = '$event_id'"; // Assuming 'eventt' is the table name and 'eid' is the primary key

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Event deleted successfully, redirect back to adminevent.php
        header("Location: adminevent.php");
        exit();
    } else {
        echo "Error deleting event: " . $conn->error;
    }
} else {
    echo "Invalid event ID";
}

$conn->close(); // Close the database connection
?>

<?php
// Start session
session_start();

// Include database connection
include("db_conn.php");

// Check if the volunteer_id is set and not empty
if(isset($_POST['volunteer_id']) && !empty($_POST['volunteer_id'])) {
    // Sanitize the volunteer_id to prevent SQL injection
    $volunteer_id = mysqli_real_escape_string($conn, $_POST['volunteer_id']);

    // Delete the volunteer from the database
    $sql = "DELETE FROM volunteers WHERE vid = '$volunteer_id'";

    if (mysqli_query($conn, $sql)) {
        // Volunteer deleted successfully
        $_SESSION['success_message'] = "Volunteer deleted successfully.";
    } else {
        // Error deleting volunteer
        $_SESSION['error_message'] = "Error deleting volunteer: " . mysqli_error($conn);
    }
} else {
    // Redirect back to the adminvolunteer.php page if volunteer_id is not set
    header("Location: adminvolunteer.php");
    exit();
}

// Close database connection
mysqli_close($conn);

// Redirect back to the adminvolunteer.php page
header("Location: adminvolunteer.php");
exit();
?>

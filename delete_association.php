<?php
// Include database connection
include("db_conn.php");

// Check if association ID is provided and not empty
if(isset($_POST['association_id']) && !empty($_POST['association_id'])) {
    // Sanitize association ID to prevent SQL injection
    $association_id = mysqli_real_escape_string($conn, $_POST['association_id']);

    // SQL query to delete association by ID
    $sql = "DELETE FROM association WHERE aid = $association_id";

    // Attempt to execute the query
    if(mysqli_query($conn, $sql)) {
        // Association deleted successfully
        header("Location: adminassociation.php"); // Redirect back to the associations page
        exit();
    } else {
        // Error occurred while deleting the association
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Association ID is not provided or empty
    echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
?>

<?php
require 'db_conn.php';

// Check if selected_day parameter is set in the URL
if(isset($_POST["selected_day"])) {
    $selectedDay = $_GET["selected_day"];

    // Query to fetch events that match the selected day
    $query = "SELECT * FROM eventt WHERE eventday = '$selectedDay' OR FIND_IN_SET('$selectedDay', days) > 0";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if any matching events are found
    if(mysqli_num_rows($result) > 0) {
        // Events found, display them
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matching Events</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Matching Events for <?php echo htmlspecialchars($selectedDay); ?></h1>
    <ul>
        <?php
            // Display each matching event
            while($row = mysqli_fetch_assoc($result)) {
                echo "<li>{$row['eventname']} - {$row['location']}</li>";
            }
        ?>
    </ul>
    <!-- Add your HTML content here -->
</body>
</html>
<?php
    } else {
        // No matching events found
        echo "No matching events found for " . htmlspecialchars($selectedDay) . ".";
    }
} else {
    // selected_day parameter is not set in the URL
    echo "No selected day specified.";
}
?>

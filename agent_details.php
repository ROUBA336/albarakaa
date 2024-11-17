<?php
include 'db_conn.php';

// Retrieve the event ID from the request
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Query to retrieve event details
    $event_query = "SELECT * FROM eventt WHERE eid = $event_id";
    $event_result = mysqli_query($conn, $event_query);

    // Check if the query was successful
    if (!$event_result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Fetch the event details
    $event = mysqli_fetch_assoc($event_result);

    // Query to retrieve agents who have taken the event
    $agents_query = "SELECT v.* FROM volunteers v INNER JOIN assistant a ON v.vid = a.vid WHERE a.eid = $event_id";
    $agents_result = mysqli_query($conn, $agents_query);

    // Check if the query was successful
    if (!$agents_result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Fetch the agents' details
    $agents = mysqli_fetch_all($agents_result, MYSQLI_ASSOC);
} else {
    // Redirect if event ID is not provided
    header("Location: events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Agents</title>
    <!-- Add your CSS and other necessary imports -->
</head>
<body>
    <h1>Event Details</h1>
    <p>Event Name: <?php echo $event['eventname']; ?></p>
    <p>Phone: <?php echo $event['phone']; ?></p>
    <!-- Display other event details as needed -->

    <h2>Agents for Event ID: <?php echo $event_id; ?></h2>
    <ul>
        <?php foreach ($agents as $agent) : ?>
            <li><?php echo $agent['fname'] . ' ' . $agent['lname']; ?></li>
            <!-- Display other agent information as needed -->
        <?php endforeach; ?>
    </ul>
    <!-- Add your HTML content here -->
</body>
</html>

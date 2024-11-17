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

// Query to retrieve volunteer details from the database
$volunteer_query = "SELECT * FROM volunteers WHERE username = '$username'";

// Execute the query
$volunteer_result = mysqli_query($conn, $volunteer_query);

// Check if the query was successful
if (!$volunteer_result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Fetch volunteer details
$volunteer_details = mysqli_fetch_assoc($volunteer_result);

// Fetch all events from the database
$available_days = explode(", ", $volunteer_details['availableday']);
$free_day = $volunteer_details['freeday'];

// Initialize the events query
$events_query = "";

// Build the condition to match each event day with available days
$conditions = [];
foreach ($available_days as $available_day) {
    $conditions[] = "FIND_IN_SET('$available_day', days)";
}
$conditions_str = implode(' OR ', $conditions);

// Query to fetch events with matching availability days or event days based on volunteer status
if ($volunteer_details['status'] === 'always') {
    $events_query = "SELECT * FROM eventt WHERE ($conditions_str)";
} elseif ($volunteer_details['status'] === 'one') {
    $events_query = "SELECT * FROM eventt WHERE eventday = '$free_day'";
} else {
    // Set a default query to retrieve all events
    $events_query = "SELECT * FROM eventt";
}

// Execute the query
$events_result = mysqli_query($conn, $events_query);

// Check if the query was successful
if (!$events_result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Fetch the matching events
$matching_events = mysqli_fetch_all($events_result, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['take_event'])) {
    $event_id = $_POST['event_id'];
    
    // Check the volunteering type of the volunteer
    if ($volunteer_details['volunteeringtype'] === 'Agent') {
        // Insert data into the assistant table
        $insert_query = "INSERT INTO assistant (eid, vid) VALUES ('$event_id', '{$volunteer_details['vid']}')";
    } elseif ($volunteer_details['volunteeringtype'] === 'Driver') {
        // Insert data into the driver table
        $insert_query = "INSERT INTO driver (eid, vid) VALUES ('$event_id', '{$volunteer_details['vid']}')";
    } else {
        echo "Error: Unable to determine volunteering type.";
        exit();
    }
    
    // Execute the insert query
    if (mysqli_query($conn, $insert_query)) {
        header("Location:events_details.php?event_id=123");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
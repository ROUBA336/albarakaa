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

    // Query to retrieve the volunteer's details including the volunteering type
    session_start();
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Query to retrieve the volunteer's details
        $volunteer_query = "SELECT *, volunteeringtype FROM volunteers WHERE username = '$username'";
        $volunteer_result = mysqli_query($conn, $volunteer_query);

        // Check if the query was successful
        if (!$volunteer_result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        }

        // Fetch the volunteer's details
        $volunteer = mysqli_fetch_assoc($volunteer_result);

        // Initialize variable for participants
        $participants = [];

        // Query to retrieve participants based on volunteering type
        if ($volunteer['volunteeringtype'] === 'Agent') {
            // Query to retrieve drivers who have taken the same event
            $participants_query = "SELECT v.* FROM volunteers v INNER JOIN driver d ON v.vid = d.vid WHERE d.eid = $event_id";
        } elseif ($volunteer['volunteeringtype'] === 'Driver') {
            // Query to retrieve agents who have taken the same event
            $participants_query = "SELECT v.* FROM volunteers v INNER JOIN assistant a ON v.vid = a.vid WHERE a.eid = $event_id";
        } else {
            // Invalid volunteering type
            echo "Invalid volunteering type";
            exit();
        }

        // Execute the participants query
        $participants_result = mysqli_query($conn, $participants_query);

        // Check if the query was successful
        if (!$participants_result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        }

        // Fetch the participants' details
        $participants = mysqli_fetch_all($participants_result, MYSQLI_ASSOC);
    } else {
        // Redirect if the username is not set in session
        header("Location: login.php");
        exit();
    }

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
    <title>Participants for Event</title>
    <style>
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.container {
    display: flex;
    justify-content: space-between;
    max-width: 800px;
    margin: 20px auto;
}

.event-details,
.participants {
    flex-basis: 45%;
}

.event-info,
.participant-list {
    padding: 20px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.event-details h2,
.participants h2 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #152d53;
}

.participant {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.participant p {
    margin: 8px 0;
    color: #555;
}

.participant p strong {
    color: #333;
}

.no-participants {
    color: #666;
    font-style: italic;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .event-details,
    .participants {
        width: 100%;
        margin-bottom: 20px;
    }
}

/* Adjustments for button placement */



        </style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event and Participant Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <div class="event-details">
            <h1 style="margin-left:76px;color:#152d53;">Event Details</h1>
            <div class="event-info" style="background-color:#fc3b00;color:white;font-size:26px;">
                <p><strong>Event Name:</strong> <?php echo $event['eventname']; ?></p>
                <p><strong>Phone:</strong> <?php echo $event['phone']; ?></p>
                <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
                <p><strong>Food Item:</strong> <?php echo $event['fooditem']; ?></p>
                <p><strong>Delivery Time:</strong> <?php echo $event['deliverytime']; ?></p>
                <?php if ($event['status'] === 'always'): ?>
                    <?php if (!empty($event['days'])): ?>
                        <p><strong>Available Days:</strong> <?php echo implode(', ', explode(',', $event['days'])); ?></p>
                    <?php else: ?>
                        <p><strong>Available Days:</strong> None</p>
                    <?php endif; ?>
                <?php elseif ($event['status'] === 'one'): ?>
                    <p><strong>Event Day:</strong> <?php echo $event['eventday']; ?></p>
                <?php endif; ?>
                <!-- Add other event details here -->
            </div>
        </div>

        <div class="participants" >
            <h1 style="margin-left:23px;color:#152d53;"><?php echo ($volunteer['volunteeringtype'] === 'Agent') ? 'Driver' : 'Agent'; ?> for this Event</h1>
            <ul class="participant-list" style="background-color:#fc3b00;">
                <?php foreach ($participants as $participant) : ?>
                    <div class="participant">
                        <p style="font-size:26px;"><strong style="color:#152d53;font-family:monospace;">Name:</strong> <?php echo $participant['fname'] . ' ' . $participant['lname']; ?></p>
                        <p style="font-size:26px;"><strong style="color:#152d53;font-family:monospace;">Phone:</strong> <?php echo $participant['phone']; ?></p>
                        <!-- Add other participant details here -->
                    </div>
                <?php endforeach; ?>
            </ul>
            <?php if (empty($participants)) : ?>
                <p style="text-align:center;color:#fc3b00;font-size:18px;"><b>No <?php echo ($volunteer['volunteeringtype'] === 'Agent') ? 'driver' : 'agent'; ?> found for this event.</b></p>
            <?php endif; ?>
          
            <?php if ($volunteer['volunteeringtype'] === 'Driver' && empty($participants)) : ?>
            <form action="take_agent.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <button style="text-decoration: none; color: white; font-size: 19px; padding: 10px 20px; background-color:#152d53 ;margin-left:220px; border-radius: 8px;" type="submit" <?php echo (!empty($participants)) ? 'disabled' : ''; ?>>Make me agent</button>
            </form>
        <?php elseif ($volunteer['volunteeringtype'] === 'Agent' && empty($participants)) : ?>
            <form action="take_driver.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <button style="text-decoration: none; color: white; font-size: 18px; padding: 10px 20px; background-color:#152d53 ;margin-left:220px; border-radius: 8px;" type="submit" <?php echo (!empty($participants)) ? 'disabled' : ''; ?>>Make me driver</button>
            </form>
        <?php endif; ?>
     
        </div>

    </div>
    
    <div style="text-align: center; margin-top: -70px;margin-left:680px;">
        <a href="homevolun.php" style="text-decoration: none; color: white; font-size: 24px; padding: 10px 20px; background-color:#152d53 ; border-radius: 8px;">Go Back</a>
    </div>
</body>


</html>

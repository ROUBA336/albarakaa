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
$available_days = explode(",", $volunteer_details['availableday']);
// Build the condition to match each event day with available days of the volunteer

$free_day = $volunteer_details['freeday'];

// Initialize the events query
$events_query = "";

// Build the condition to match each event day with available days
$conditions = [];

// Add condition to match event day with the volunteer's free day
$conditions[] = "eventday = '$free_day'";
$days_str = "'" . implode("','", $available_days) . "'";

// Add condition to match event day with available days of the volunteer
$conditions[] = "days IN ($days_str)";

// Combine the conditions with AND operator to ensure that all conditions are met
$conditions_str = implode(' AND ', $conditions);


$agent_conditions = [];

// Add condition to match event day with the volunteer's free day
$agent_conditions[] = "eventday = '$free_day'";
$days_str = "'" . implode("','", $available_days) . "'";

// Add condition to match event day with available days of the volunteer
$agent_conditions[] = "days IN ($days_str)";

$agent_conditions_str = implode(' AND ', $agent_conditions);

// Combine the conditions with AND operator to ensure that all conditions are met

// Query to fetch events that match the conditions
$events_available_query = "SELECT * FROM eventt WHERE ($conditions_str)";

// Modify the query for driver volunteers
if ($volunteer_details['volunteeringtype'] === 'Driver') {
    // Query to fetch events taken by the current driver volunteer
    $events_taken_query = "SELECT eventt.* FROM eventt INNER JOIN driver ON eventt.eid = driver.eid WHERE driver.vid = '{$volunteer_details['vid']}'";

    // Query to fetch events that match the updated conditions and are not taken by any driver volunteer
    $events_available_query = "SELECT * FROM eventt WHERE ($conditions_str) AND eid NOT IN (SELECT eid FROM driver)";

    // Combine the two queries using UNION to get all events
    $events_query = "($events_taken_query) UNION ($events_available_query)";
    $events_result = mysqli_query($conn, $events_query);
}elseif ($volunteer_details['volunteeringtype'] === 'Agent') {

    $events_taken_query = "SELECT eventt.* FROM eventt INNER JOIN assistant ON eventt.eid = assistant.eid WHERE assistant.vid = '{$volunteer_details['vid']}'";

    // Modify the events available query to include events not taken by any agent
    $events_available_query = "SELECT * FROM eventt WHERE ($agent_conditions_str) AND (eid NOT IN (SELECT eid FROM assistant) OR eid IN (SELECT eid FROM assistant WHERE vid = '{$volunteer_details['vid']}'))";

    // Combine the two queries using UNION to get all events
    $events_query = "($events_taken_query) UNION ($events_available_query)";



    $events_result = mysqli_query($conn, $events_query);
}

// Execute the query


// Check if the query was successful
if (!$events_result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$matching_events = mysqli_fetch_all($events_result, MYSQLI_ASSOC);
// Handle form submission
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
        header("Location: homevolun.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th{
            padding: 8px;
            text-align: center;
            border-bottom: 4px solid #ddd;
            background:#ddd;
            opacity:1;
            height:57px;
            font-size:23px;
            color:rgba(255, 72, 0, 0.932);
            
        }
         td {
            padding: 8px;
            text-align:center;
            border-bottom: 2px solid #ddd;
            color:#162f57;
            font-size:20px;
        }
      
           .take-btn:disabled {
        /* Style for disabled button */
        background-color: #f0f0f0; /* Change to your desired color */
        color: #999; /* Change to your desired color */
        cursor: not-allowed;
    }
        
        .take-btn {
          padding: 8px 16px;
          background-color: #162f57 ; 
          border: none;
          color: white;
          text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 14px;
          margin: 4px 2px;
          cursor: pointer;
         border-radius: 4px;
         }
      
       .take-btn:hover{
          background-color: rgba(255, 72, 0, 0.932);/* Darker green */
        }

        /* Style for the "View Location" button */
.view-location-btn {
    padding: 8px 16px;
    background-color: #ff4a04; /* Adjust the color as needed */
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 4px;
}

.view-location-btn:hover {
    background-color: #ff6633; /* Adjust the hover color as needed */
}



        .show-all-btn {
      padding: 9px 10px;
      background-color: #162f57; 
      border: none;
      color: white;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin-left: 20px; /* Add margin-left for spacing */
      cursor: pointer;
      border-radius: 4px;
    }
    .show-all-btn:hover{
      background-color: rgba(255, 72, 0, 0.932); #162f57/* Darker green */
    }
    .view-more-btn {
    padding: 8px 16px;
    background-color: #ff4a04; /* Adjust the color as needed */
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 4px;
}

.view-more-btn:hover {
    background-color: #ff6633; /* Adjust the hover color as needed */
}
.view-more-btn:disabled {
    /* Style for disabled button */
    background-color: #f0f0f0; /* Change to your desired color */
    color: #999; /* Change to your desired color */
    cursor: not-allowed;
}




#mapModal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    #map {
        height: 400px;
        width: 100%;
    }

    .close {
            cursor: grab;
}
.caption {
    background-color: #f9f9f9;
    padding: 10px;
    border: 1px solid #ddd;
    border-top: none;
    max-width: 300px; /* Adjust the max-width as needed */
}

.driver-caption-container {
    position: relative;
}

.driver-info {
    font-size:29px; /* Adjust the font size as needed */
   /* Optional: make the text bold */
   font-family: monospace;
   font-weight:bold;
    color: #162f57; /* Adjust the color as needed */
}

    </style>
</head>
<body>
    <header class="header-area">
        <div class="header-container">
            <div class="site-logo">
                <a href="#">AL<span>BARAKA</span></a>
                
                <a href="#" style="font-size:30px;font-weight:bold;margin-left:170px;"><strong style="color:white;">Welcome</strong> <b style="color:#ff4a04;font-family: cursive;font-size:39px;"><?php echo $username; ?></b></a>
                
            </div>
            <div class="mobile-nav">
                <i class="fas fa-bars"></i>
            </div>
            <div class="site-nav-menu">
                <ul class="primary-menu">
                    
                <li><a href="profileevolun.php">My Profile</a></li>
                    <li><a href="#" class="active">Requests</a></li>
                
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
                <div class="menu-toggle"></div>
            </div>
        </div>
    </header>
<!-- Header and navigation menu goes here -->

<main>
    <!-- Display fetched events here -->
    <div class="main-box top">
            <div class="top" style="margin-left:350px;">
             <br>
             <h2 style="text-align:center;color:#162f57;font-size:30px; display: inline-block; margin-right: 20px;">Take action to be member of charitable work</h2>
            <button class="show-all-btn" value="showallevent" id="showallevent" name="showallevent"
            onclick="location.href='show_all_events.php';">Show All Events</button>
</div>
                <br>
                <div class="box" >
                    
<table>
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Phone</th>
            <?php if ($volunteer_details['status'] === 'always') : ?>
                <th>Days</th>
            <?php elseif ($volunteer_details['status'] === 'one') : ?>
                <th>Event Day</th>
                <?php endif; ?>
            <th>Location</th>
            <th>Food Item</th>
            <th>Delivery Time</th>
            <th>Status</th>
            
            <th>Actions</th>
      
            <?php if ($volunteer_details['volunteeringtype'] === 'Driver') : ?>
                <th>Agent</th>
            <?php endif; ?>
            <?php if ($volunteer_details['volunteeringtype'] === 'Agent') : ?>
                <th>Driver</th>
            <?php endif; ?>
            <?php if ($volunteer_details['volunteeringtype'] === 'Driver') : ?>
                <th>Association</th>
            <?php endif; ?>
        
            <!-- Add more table headers if needed -->
        </tr>
    </thead>
    <tbody>
    <?php if ($volunteer_details['volunteeringtype'] === 'Driver') : ?>
        
    <?php foreach ($matching_events as $event) : ?>
        <?php 
            // Fetch the agents associated with the event
            $agents_query = "SELECT volunteers.fname, volunteers.phone FROM volunteers INNER JOIN assistant ON volunteers.vid = assistant.vid WHERE assistant.eid = '{$event['eid']}'";
            $agents_result = mysqli_query($conn, $agents_query);
        
            // Check if there are any agents associated with the event
            if (mysqli_num_rows($agents_result) > 0) {
                // Display the event details in the table
        ?>
                <tr>
                    <td><?php echo $event['eventname']; ?></td>
                    <td><?php echo $event['phone']; ?></td>
                    <?php if ($volunteer_details['status'] === 'always') : ?>
                        <td><?php echo $event['days']; ?></td>
                    <?php elseif ($volunteer_details['status'] === 'one') : ?>
                        <td><?php echo $event['eventday']; ?></td>
                    <?php endif; ?>
                    <td>
                        <button class="view-location-btn" onclick="openMapModal(<?php echo $event['latitude']; ?>, <?php echo $event['logitude']; ?>)">View Location</button>
                    </td>
                    <td><?php echo $event['fooditem']; ?></td>
                    <td><?php echo date("H:i", strtotime($event['deliverytime'])); ?></td>
                    <td><?php echo $event['status']; ?></td>
                    <td class="actions">
                        <form method="POST" action="">
                            <input type="hidden" name="event_id" value="<?php echo $event['eid']; ?>">
                            <?php 
                                // Check if the event has already been taken by a driver
                                $check_query = "SELECT * FROM driver WHERE eid = '{$event['eid']}'";
                                $check_result = mysqli_query($conn, $check_query);
                                if (mysqli_num_rows($check_result) > 0) {
                                    // If the event has been taken by a driver, disable the button
                                    echo '<button class="take-btn" name="take_event" id="take_event" disabled>Already Taken</button>';
                                } else {
                                    // If the event has not been taken by a driver, display the button
                                    echo '<button class="take-btn" name="take_event" id="take_event">Take</button>';
                                }
                            ?>
                        </form>
                    </td>
                    <td>
                        <?php 
                            // Loop through each agent and display their name and phone number
                            while ($agent = mysqli_fetch_assoc($agents_result)) {
                                echo $agent['fname'] . ' - ' . $agent['phone'] . '<br>';
                            }
                        ?>
                    </td>
                  

                    <td>
                        <?php 
                            // Display the "View Association" button
                            echo '<form method="GET" action="view_association.php">';
                            echo '<input type="hidden" name="event_id" value="' . $event['eid'] . '">';
                            echo '<button class="view-more-btn" type="submit" name="view_association">View Association</button>';
                            echo '</form>';
                        ?>
                    </td>
                </tr>
        <?php
            }
        ?>
    <?php endforeach; ?>
<?php else : ?>
    <?php foreach ($matching_events as $event) : ?>
        <?php 
            // Fetch the agents associated with the event
            $agents_query = "SELECT volunteers.fname, volunteers.phone FROM volunteers INNER JOIN assistant ON volunteers.vid = assistant.vid WHERE assistant.eid = '{$event['eid']}'";
            $agents_result = mysqli_query($conn, $agents_query);
        
            // Display the event details in the table
        ?>
        <tr>
            <td><?php echo $event['eventname']; ?></td>
            <td><?php echo $event['phone']; ?></td>
            <?php if ($volunteer_details['status'] === 'always') : ?>
                <td><?php echo $event['days']; ?></td>
            <?php elseif ($volunteer_details['status'] === 'one') : ?>
                <td><?php echo $event['eventday']; ?></td>
            <?php endif; ?>
            <td>
                <button class="view-location-btn" onclick="openMapModal(<?php echo $event['latitude']; ?>, <?php echo $event['logitude']; ?>)">View Location</button>
            </td>
            <td><?php echo $event['fooditem']; ?></td>
            <td><?php echo date("H:i", strtotime($event['deliverytime'])); ?></td>
            <td><?php echo $event['status']; ?></td>
            <td class="actions">
    <form method="POST" action="">
        <input type="hidden" name="event_id" value="<?php echo $event['eid']; ?>">
        <?php 
            // Check if the event has already been taken by an agent
            $check_query = "SELECT * FROM assistant WHERE eid = '{$event['eid']}'";
            $check_result = mysqli_query($conn, $check_query);
            if (mysqli_num_rows($check_result) > 0) {
                // If the event has been taken by an agent, disable the button
                echo '<button class="take-btn" name="take_event" id="take_event" disabled>Already Taken</button>';
            } else {
                // If the event has not been taken by an agent, display the button
                echo '<button class="take-btn" name="take_event" id="take_event">Take</button>';
            }
        ?>
    </form>
</td>
<td>
    <div class="driver-caption-container">
        <button id="viewDriverBtn_<?php echo $event['eid']; ?>" class="view-more-btn" onclick="toggleCaption('<?php echo $event['eid']; ?>')">View Driver</button>
        <div id="driverCaption_<?php echo $event['eid']; ?>" class="caption" style="display: none;">
            <?php 
                // Fetch the driver associated with the event
                $driver_query = "SELECT volunteers.fname, volunteers.phone FROM volunteers INNER JOIN driver ON volunteers.vid = driver.vid WHERE driver.eid = '{$event['eid']}'";
                $driver_result = mysqli_query($conn, $driver_query);
            
                // Check if there is a driver associated with the event
                if (mysqli_num_rows($driver_result) > 0) {
                    // Display the driver's name and phone number
                    $driver_info = mysqli_fetch_assoc($driver_result);
                    echo "<span class='driver-info'>" . $driver_info['fname'] . " - " . $driver_info['phone'] . "</span>";
                } else {
                    echo "<span class='driver-info'>No Driver Assigned</span>";
                }
            ?>
        </div>
    </div>
</td>


        </tr>
    <?php endforeach; ?>
<?php endif; ?>

    </tbody>
</table>
</div>
            </div>
        </div>
        <div id="mapModal">
    <div class="modal-content">
        <span class="close" onclick="closeMapModal()">&times;</span>
        <div id="map"></div>
    </div>
</div>
</main>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

 
    <script>
    // Function to open the map modal and display location
// Function to open the map modal and display location
function openMapModal(lat, lng) {
    document.getElementById('mapModal').style.display = 'block';

    // Remove existing map if it exists
    var existingMap = document.getElementById('map');
    if (existingMap) {
        existingMap.remove();
    }

    // Create a new map element
    var newMap = document.createElement('div');
    newMap.id = 'map';
    newMap.style.height = '400px';
    newMap.style.width = '100%';

    // Append the new map element to the modal content
    document.querySelector('.modal-content').appendChild(newMap);

    // Initialize Leaflet map
    var map = L.map('map').setView([lat, lng], 13);

    // Add tile layer from OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add marker at the specified location
    L.marker([lat, lng]).addTo(map);
}
function closeMapModal() {
        document.getElementById('mapModal').style.display = 'none';
    }

 
    function toggleCaption(eventId) {
        var btn = document.getElementById('viewDriverBtn_' + eventId);
        var caption = document.getElementById('driverCaption_' + eventId);
        
        if (caption.style.display === 'none') {
            caption.style.display = 'block';
            btn.innerText = 'Hide Driver';
        } else {
            caption.style.display = 'none';
            btn.innerText = 'View Driver';
        }
    }


</script>
<!-- Footer and any other scripts go here -->
</body>
</html>

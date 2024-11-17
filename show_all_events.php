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

// Retrieve the volunteer details to determine the volunteering type
$volunteer_query = "SELECT * FROM volunteers WHERE username = '$username'";
$volunteer_result = mysqli_query($conn, $volunteer_query);

if (!$volunteer_result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$volunteer_details = mysqli_fetch_assoc($volunteer_result);

// Query to retrieve all events from the database
$events_query = "SELECT * FROM eventt";

// Execute the query
$events_result = mysqli_query($conn, $events_query);

// Check if the query was successful
if (!$events_result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Check if the form is submitted and the event is being taken
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['take_event'])) {
    $event_id = $_POST['event_id'];

    // Check if the event has already been assigned to a driver or an agent
    $check_query = "";
    if ($volunteer_details['volunteeringtype'] === 'Driver') {
        $check_query = "SELECT * FROM driver WHERE eid = '$event_id'";
    } elseif ($volunteer_details['volunteeringtype'] === 'Agent') {
        $check_query = "SELECT * FROM assistant WHERE eid = '$event_id'";
    }

    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // If the event has already been assigned, redirect back to the page
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: show_all_events.php");
        exit();
    }

    // Insert the event into the appropriate table
    if ($volunteer_details['volunteeringtype'] === 'Driver') {
        // Insert data into the driver table
        $insert_query = "INSERT INTO driver (eid, vid) VALUES ('$event_id', '{$volunteer_details['vid']}')";
    } elseif ($volunteer_details['volunteeringtype'] === 'Agent') {
        // Insert data into the assistant table
        $insert_query = "INSERT INTO assistant (eid, vid) VALUES ('$event_id', '{$volunteer_details['vid']}')";
    } else {
        echo "Error: Unable to determine volunteering type.";
        exit();
    }

    // Execute the insert query
    if (mysqli_query($conn, $insert_query)) {
        echo "Event taken successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Query to check if any events have been assigned to drivers or agents
$assigned_events_driver_query = "SELECT eid FROM driver";
$assigned_events_agent_query = "SELECT eid FROM assistant";

// Execute the queries
$assigned_events_driver_result = mysqli_query($conn, $assigned_events_driver_query);
$assigned_events_agent_result = mysqli_query($conn, $assigned_events_agent_query);

// Create arrays to store assigned event IDs for drivers and agents
$assigned_events_driver = [];
$assigned_events_agent = [];
while ($row = mysqli_fetch_assoc($assigned_events_driver_result)) {
    $assigned_events_driver[] = $row['eid'];
}
while ($row = mysqli_fetch_assoc($assigned_events_agent_result)) {
    $assigned_events_agent[] = $row['eid'];
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
            .actions {
                display: flex;
                justify-content: center;
                gap: 10px;
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
.close {
            cursor: grab;
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

    
 /* Add custom styles for the map modal */
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
                        <li><a href="homevolun.php" >Requests</a></li>
                    
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
                    <div class="menu-toggle"></div>
                </div>
            </div>
        </header>

    <!-- Header content remains unchanged -->
    <!-- Body content remains unchanged -->
    <div class="box" style="margin-top:8px;">
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Food Item</th>
                    <th>Delivery Time</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>View</th>
                    <th>Association</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($event = mysqli_fetch_assoc($events_result)) : ?>
                    <tr>
                        <td><?php echo $event['eventname']; ?></td>
                        <td><?php echo $event['phone']; ?></td>
                        <td>
    
    <button class="view-location-btn" onclick="openMapModal(<?php echo $event['latitude']; ?>, <?php echo $event['logitude']; ?>)">View Location</button>

</td>
                        <td><?php echo $event['fooditem']; ?></td>
                        <td><?php echo $event['deliverytime']; ?></td>
                        <td><?php echo $event['status']; ?></td>
                        <td class="actions">
                            <form method="POST">
                                <input type="hidden" name="event_id" value="<?php echo $event['eid']; ?>">
                                <?php
if ($volunteer_details['volunteeringtype'] === 'Driver') {
    // Disable the button if the event has been taken by any driver
    if (in_array($event['eid'], $assigned_events_driver)) {
        echo '<button class="take-btn" name="take_event" id="take_event" disabled>Already Taken</button>';
    } else {
        echo '<button class="take-btn" name="take_event" id="take_event">Take</button>';
    }
}
// Check if the current user is an agent
elseif ($volunteer_details['volunteeringtype'] === 'Agent') {
    // Disable the button only if there are no agents who have taken the event
    if (!in_array($event['eid'], $assigned_events_agent)) {
        echo '<button class="take-btn" name="take_event" id="take_event">Take</button>';
    } else {
        echo '<button class="take-btn" name="take_event" id="take_event" disabled>Already Taken</button>';
    }
}
?>

                            </form>
                        </td>



                        <td class="view-more">
    <?php 
        // Determine the text for the button based on the volunteering type of the current volunteer
        $button_text = ($volunteer_details['volunteeringtype'] === 'Driver') ? 'View Agents' : 'View Drivers';

        // Check if the event has been taken by either a driver or an agent
        $check_query = ($volunteer_details['volunteeringtype'] === 'Driver') ? 
            "SELECT * FROM driver WHERE eid = '{$event['eid']}'" : 
            "SELECT * FROM assistant WHERE eid = '{$event['eid']}'";
        $check_result = mysqli_query($conn, $check_query);

        // Check if the event has been taken by the current volunteer
        $current_volunteer_taken = false;
        if (mysqli_num_rows($check_result) > 0) {
            while ($row = mysqli_fetch_assoc($check_result)) {
                if ($row['vid'] == $volunteer_details['vid']) {
                    $current_volunteer_taken = true;
                    break;
                }
            }
        }

        if ($current_volunteer_taken) {
            // If the event has been taken by the current volunteer, enable the "View Drivers" or "View Agents" button
    ?>
        <form method="GET" action="driver_event_agents.php">
            <input type="hidden" name="event_id" value="<?php echo $event['eid']; ?>">
            <button class="view-more-btn" type="submit" name="view_more_event"><?php echo $button_text; ?></button>
        </form>
    <?php 
        } else {
            // If the event has not been taken by the current volunteer, keep the "View Drivers" or "View Agents" button disabled
    ?>
        <button class="view-more-btn" disabled><?php echo $button_text; ?></button>
    <?php 
        } 
    ?>
</td>



<td>
    <?php 
        // Check if the event has an association
   
            // Display the "View Association" button
            echo '<form method="GET" action="view_association.php">';
            echo '<input type="hidden" name="event_id" value="' . $event['eid'] . '">';
            echo '<button class="view-more-btn" type="submit" name="view_association">View Association</button>';
            echo '</form>';
      
    ?>
</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div id="mapModal">
    <div class="modal-content">
        <span class="close" onclick="closeMapModal()">&times;</span>
        <div id="map"></div>
    </div>
</div>
    </div>

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


</script>
</body>
</html>

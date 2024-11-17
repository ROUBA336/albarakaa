<?php 
session_start();

// Include database connection
include("db_conn.php");

// Redirect to login page if user is not logged in
if(!isset($_SESSION['username'])){
    header("Location: events.php");
    exit();
}

// Retrieve user's event information from the database
$username = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM eventt WHERE username='$username'");
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
            border-bottom: 3px solid #ddd;
            background:#ddd;
            color:rgba(255, 72, 0, 0.932);
            
        }
         td {
            padding: 9px;
            text-align:center;
            border-bottom: 2px solid #ddd;
            color:#162f57;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

         .delete-btn{
            padding: 8px 16px;
          background-color:  rgba(255, 72, 0, 0.932);
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
        .update-btn {
          padding: 8px 16px;
          background-color: #162f57; 
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
       .delete-btn:hover{
               background-color: #162f57;
         }
       .update-btn:hover{
          background-color: rgba(255, 72, 0, 0.932);/* Darker green */
        }
       

        .close {
            cursor: grab;
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
               <a href="#" style="font-size:40px;font-weight:bold;margin-left:170px;">Welcome <b style="color:#ff4a04;font-family: cursive;font-size:43px;"><?php echo $username; ?></b></a>
                
            </div>
            <div class="mobile-nav">
                <i class="fas fa-bars"></i>
            </div>
            <div class="site-nav-menu">
                <ul class="primary-menu">
                    <li><a href="#" class="active">My Profile</a></li>
                    <li><a href="eventprofile.php">Add Event</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
                <div class="menu-toggle"></div>
            </div>
        </div>
    </header>

    <main>
  
        <div class="main-box top">
            <div class="top">
             
                <br><br>
                <div class="box" style="margin-top:-36px;">
                    
                    <table>
                        <tr>
                            <th>Event Name</th>
                            <th>Phone</th>
                           
                            <th>Food Items</th>
                            <th>Delivery Time</th>
                            <th>Status</th>
                            <th>Days</th>
                            <th>Event Day</th>
                            <th  style="margin-left:-100px">Actions</th> <!-- Added this -->
                            
                        </tr>
                        <?php
                        // Display each event in a table row
                        while ($row = mysqli_fetch_assoc($query)) {
                            // Format delivery time to HH:MM
                            $deliveryTime = date("g:i", strtotime($row['deliverytime']));
                            ?>
                            <tr>
                                <td><?php echo $row['eventname']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
   

                                <td><?php echo $row['fooditem']; ?></td>
                                <td><?php echo $deliveryTime; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['days']; ?></td>
                                <td><?php echo ($row['eventday'] != '0000-00-00') ? $row['eventday'] : ''; ?></td>
                                <td class="actions">
                                <button class="update-btn" onclick="window.location.href='updateevent.php?id=<?php echo $row['eid']; ?>'">Update</button>

                                    <button class="delete-btn" onclick="window.location.href='deleteevent.php?id=<?php echo $row['eid']; ?>'">Delete</button>

                                </td>
                            
                            </tr>
                            <?php
                        }
                        ?>
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


</script>
</body>
</html>

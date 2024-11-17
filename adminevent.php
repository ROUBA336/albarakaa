
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin Dashboard | Keyframe Effects</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="updateprofile.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>

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
    .view-location-btn {
    padding: 8px 16px;
    background-color: #ff4a04; /* Adjust the color as needed */
    border: none;
    color: white;
    width:120px;
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
    .orange-text {
    color: #ff4a04;
    font-size:20px;
    font-weight:bold;
}
th {
            color: #ff4a04;
            font-size: 22px;
            text-align: center;
        }

        td {
            color: #152d53;
            font-size: 21px;
            text-align: center;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            margin-top:20px;
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
        }


    </style>
</head>
<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>Admin</h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(logo.jpeg)"></div>
                <h4>Rouba Ayach</h4>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="admin.php">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="updateprofile.php">
                            <span class="las la-user-alt"></span>
                            <small>Profile</small>
                        </a>
                    </li>
                    <li>
                        <a href="adminevent.php" class="active">
                            <span class="las la-calendar-check"></span>
                            <small>Events</small>
                        </a>
                    </li>
                    <li>
                        <a href="adminvolunteer.php">
                            <span class="las la-hands-helping"></span>
                            <small>Volunteers</small>
                        </a>
                    </li>
                    <li>
                        <a href="adminassociation.php">
                            <span class="las la-home"></span>
                            <small>Associaations</small>
                        </a>
                    </li>
                    <li>
                        <a href="a.php" >
                            <span class="lab la-autoprefixer"></span>
                            <small>Always </small>
                        </a>
                    </li>
                    <li>
                        <a href="onetime.php"  >
                            <span class="las la-hand-pointer" ></span>
                            <small>One time </small>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                <div class="header-menu">
                    <div class="user">
                        <div class="bg-img" style="background-image: url(logo.jpeg)"></div>
                        <i class='bx bx-power-off' style="color: orangered;"></i>
                        <a href="logout.php" style="font-size: 20px; color: orangered;">Logout</a>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="page-header">
                <h1>Events</h1>
                <h3>All Events</h3>
            </div>
            <div class="container">
                <?php
                // Database connection
                include 'db_conn.php';

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // SQL query to fetch event details
                $sql = "SELECT * FROM eventt"; // Assuming 'events' is the table name
                $result = $conn->query($sql);

                // Check if there are any events
                if ($result->num_rows > 0) {
                    echo '<table class="table" style="width:100%;margin-left:-20px;">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th >Event</th>';
                    echo '<th >Phone</th>';
                    echo '<th>Location</th>';
                    echo '<th>Food</th>';
                    echo '<th>Delivery Time</th>';
                    echo '<th>Status</th>';
                    echo '<th>Date</th>';
                
                    echo '<th>Day(s)</th>';
                    
                    echo '<th>Action</th>';
                  
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    // Output data of each row
                  // Output data of each row
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td style="color:#152d53;font-size:21px;">' . $row['eventname'] . '</td>';
    echo '<td style="color:#152d53;font-size:21px;">' . $row['phone'] . '</td>';
    echo '<td><button class="view-location-btn" onclick="openMapModal(' . $row['latitude'] . ', ' . $row['logitude'] . ')">View Location</button></td>';

    echo '<td style="color:#152d53;font-size:21px;">' . $row['fooditem'] . '</td>';
    echo '<td style="color:#152d53;font-size:21px;">' . $row['deliverytime'] . '</td>';
    // Apply a class for styling the status cell based on the status value
    if ($row['status'] == 'always') {
        echo '<td class="orange-text">' . $row['status'] . '</td>';
    } else {
        echo '<td style="color:#152d53;font-size:21px;">' . $row['status'] . '</td>';
    }
    // Check if eventday is '0000-00-00'
    if ($row['eventday'] == '0000-00-00') {
        echo '<td></td>'; // Display empty cell
    } else {
        echo '<td style="color:#152d53;font-size:21px;">' . $row['eventday'] . '</td>';
    }
    // Apply orange color to days if status is "always"
    if ($row['status'] == 'always') {
        echo '<td class="orange-text">' . $row['days'] . '</td>';
    } else {
        echo '<td>' . $row['days'] . '</td>';
    }
  
    echo '<td>';
    echo '<form method="POST" action="delete_event.php">'; // Adjust action attribute according to your file path
    echo '<input type="hidden" name="event_id" value="' . $row['eid'] . '">'; // Assuming event_id is the primary key of the event table
    echo '<button type="submit" class="btn btn-danger">Delete</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
 
}


                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "0 results";
                }

                $conn->close(); // Close the database connection
                ?>
            </div>
        </main>
        <div id="mapModal">
    <div class="modal-content">
        <span class="close" onclick="closeMapModal()">&times;</span>
        <div id="map"></div>
    </div>
</div>
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
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

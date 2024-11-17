<?php
require 'db_conn.php';

session_start(); // Start the session if not already started

if(isset($_POST["submit"])){
  // Get username from session
  $username = $_SESSION['username'];

  $eventname = $_POST["eventname"];
  $phone = $_POST["phone"];
  $location = $_POST["location"]; // Get location from form
  $fooditems = isset($_POST["fooditem"]) ? implode(",", $_POST["fooditem"]) : "";
  // Get food items from form
  $deliveryTime = $_POST["deliveryTime"]; // Get delivery time from form
  $status = $_POST["status"]; // Get status from form

  // Check if the "day" array exists in $_POST
  $days = isset($_POST["day"]) ? $_POST["day"] : array(); // Initialize to an empty array if not set
  
  // If $days array is not empty, concatenate selected days into a string
  $day = "";
  if(!empty($days)) {
    $day = implode(",", $days);
  }

  // Retrieve latitude and longitude from form data
  $latitude = $_POST["latitude"];
  $longitude = $_POST["longitude"];

  // Check if event is "always" and has multiple days
  if($status === "always" && count($days) > 1) {
    // Separate the event into multiple events for each day
    foreach($days as $selectedDay) {
      // Prepare SQL query using prepared statements
      $query = "INSERT INTO eventt (username, eventname, phone, location, latitude, logitude, fooditem, deliverytime, status, days, eventday) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      // Prepare the statement
      $stmt = mysqli_prepare($conn, $query);
      
      // Bind parameters
      mysqli_stmt_bind_param($stmt, "ssssddsssss", $username, $eventname, $phone, $location, $latitude, $longitude, $fooditems, $deliveryTime, $status, $selectedDay, $selectedDay);
      
      // Execute the statement
      if(mysqli_stmt_execute($stmt)) {
        // Registration successful, continue to next iteration
        continue;
      } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        // Break the loop if an error occurs
        break;
      }
  
      // Close statement
      mysqli_stmt_close($stmt);
    }
  } else {
    // Insert the event as a single event
    $eventday = isset($_POST["eventDay"]) ? $_POST["eventDay"] : NULL;
    // Prepare SQL query using prepared statements
    $query = "INSERT INTO eventt (username, eventname, phone, location, latitude, logitude, fooditem, deliverytime, status, days, eventday) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssddsssss", $username, $eventname, $phone, $location, $latitude, $longitude, $fooditems, $deliveryTime, $status, $day, $eventday);
    
    // Execute the statement
    if(mysqli_stmt_execute($stmt)) {
      // Registration successful, redirect to profile page
      header("Location: homeevent.php");
      exit();
    } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation bar design using html & css & javascript</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map { height: 400px;
       }
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 10px;
          
            margin-top:120px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        /* Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        window.onload = function() {
            // Hide or show status based on event name initially
            hideShowStatus();
        };

        // Function to hide or show status based on event name
        function hideShowStatus() {
            var eventName = document.getElementById('eventname').value;
            var alwaysRadio = document.getElementById('always');
            var alwaysLabel = document.querySelector('label[for="always"]');
            // Check if the event name is "wedding" or "graduation"
            if (eventName === "wedding" || eventName === "graduation") {
                alwaysRadio.style.display = 'none'; // Hide the "Always" radio button
                alwaysLabel.style.display = 'none'; // Hide the label for "Always"
            } else {
                alwaysRadio.style.display = 'block'; // Show the "Always" radio button
                alwaysLabel.style.display = 'block'; // Show the label for "Always"
            }
        }
        </script>
</head>
<body>
 
    <header class="header-area">
        <div class="header-container">
            <div class="site-logo">
                <a href="#">AL<span>BARAKA</span></a>
            </div>
            <div class="mobile-nav">
                <i class="fas fa-bars"></i>
            </div>
            <div class="site-nav-menu">
                <ul class="primary-menu">
                    <li><a href="homeevent.php">My Profile</a></li>
                    <li><a href="#" class="active">Add Event</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
                <div class="menu-toggle"></div>
            </div>
        </div>
    </header>

    <div class="container" style="height:800px;width:1300px;">
        <div class="left" style=" height: 795px;width:450px;"></div>
        <div class="right">
            <div class="formbox">
                <form id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                onsubmit="return validateForm()">
                    <h1 style="margin-left:-70px;">Fill Information</h1>
                    <br><br>
                    <p style="font-size:23px;margin-left:-20px;">Event</p>
                    <select name="eventname" id="eventname" required style="
                    margin-left: -20px;
                    margin-top: 10px;
                    width:29%;
                    color:#162f57 ;
                    font-size: 16px;" onchange="hideShowStatus()">
                        <option value="wedding">Wedding</option>
                        <option value="restaurant">Restaurant</option>
                        <option value="bakery">Bakery</option>
                        <option value="graduation">Graduation</option>
                    </select>
                    <br><br></br><br>
                    <p  style="font-size:23px;margin-left:-20px;">Phone Cell</p>
                    <input type="text" name="phone" id="phone" placeholder="your phone cell" style=" margin-left: -20px;width:39%;" required>
                    <br><br></br><br>
                    <p  style="font-size:23px;margin-left:-20px;">Location</p>
                    <input type="text" id="locationInput" name="location" placeholder="Choose location" readonly style=" margin-left: -20px;width:39%;" required>
                    <br><button type="button" onclick="openMapPicker()" style="margin-left:-20px;">Choose Location</button>
                    <div class="formboxx" style="margin-top:-378px; margin-left:430px;">
<!-- Add latitude and longitude display -->
<p id="latitudeLabel" style="font-size:23px;margin-left:-20px;display:none;">Latitude</p>
<input type="text" id="latitude" name="latitude" readonly style="margin-left: -20px;width:39%;display:none;"><br>

<p id="longitudeLabel" style="font-size:23px;margin-left:-20px;display:none;">Longitude</p>
<input type="text" id="longitude" name="longitude" readonly style="margin-left: -20px;width:39%;display:none;"><br>


                   <p style="font-size:23px;margin-top:-50px;" >Food Items</p>
                
                    <input type="checkbox" id="meat" name="fooditem[]" value="Meat"  style="margin-left:-5px;">
                    <label for="meat" style="margin-left:-18px;">Meat</label><br>
                    <input type="checkbox" id="baked" name="fooditem[]" value="Baked" style="margin-left:-5px;" >
                    <label for="baked"style="margin-left:-20px;">Baked Goods</label><br>
                    <input type="checkbox" id="cooked" name="fooditem[]" value="Cooked" style="margin-left:-5px;">
                    <label for="cooked"  style="margin-left:-18px;">Cooked Food</label><br>
                    <input type="checkbox" id="sweet" name="fooditem[]" value="Sweet" style="margin-left:-5px;">
                    <label for="sweet" style="margin-left:-18px;">Sweet</label><br>
                    <br>


<p style="font-size:23px;">Time of Delivery</p>
<input type="time" name="deliveryTime" style="width:70%;">
<br><br>
<div id="statusField">
                        <p style="font-size:23px;">Status</p>
                        
                        <input type="radio" id="always" name="status" value="always" onclick="showDays()" >
                        <label for="always" style="margin-top:-17px;margin-left:50px;">Always</label>
                        <input type="radio" id="one" name="status" value="one" onclick="showCalendar()" >
                        <label for="one" style="margin-left:-76px;">Once Time</label><br>
                    </div>
<br><br>
<div id="eventFields" style="display: none;margin-top: -30px;">
    <p>Event Day</p>
    <input type="date" name="eventDay" id="eventDay" style="width:70%;" >
</div>

<div id="eventField" style="display: none;margin-top: -10px;">
    <p>Days of Delivery</p>
    
    <input type="checkbox" name="day[]" value="monday" style="margin-left: -5px;">
    <label for="monday" style="  margin-left: -20px;">Monday</label><br>
    <input type="checkbox" name="day[]" value="tuesday"  style="margin-left: -5px;">
    <label for="tuesday" style="  margin-left: -20px;">Tuesday</label><br>
    <input type="checkbox"  name="day[]" value="wednesday"  style="margin-left: -5px;">
    <label for="wednesday" style="  margin-left: -20px;">Wednesday</label><br>
    <input type="checkbox" name="day[]" value="thursday"  style="margin-left: -5px;">
    <label for="thursday" style="  margin-left: -20px;">Thursday</label><br>
    <input type="checkbox"  name="day[]" value="friday"  style="margin-left: -5px;">
    <label for="friday" style="  margin-left: -20px;">Friday</label><br>
    <input type="checkbox"  name="day[]" value="saturday"  style="margin-left: -5px;">
    <label for="saturday" style="  margin-left: -20px;">Saturday</label><br>
    <input type="checkbox" name="day[]" value="sunday"  style="margin-left: -5px;">
    <label for="sunday" style="  margin-left: -20px;">Sunday</label><br>
    <br>
</div>

<input type="submit" name="submit" value="Submit">
</div>
</form>
</div>
</div>

<!-- Modal for the map -->
<div id="mapModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeMapModal()">&times;</span>
        <div id="map"></div>
        <button onclick="selectLocation()">Select Location</button>
    </div>
</div>

<script>
// Declare marker variable outside the function to make it accessible globally
var marker;

// Function to open the map modal
function openMapPicker() {
    document.getElementById('mapModal').style.display = 'block';
    // Initialize Leaflet map
    var map = L.map('map').setView([33.8547, 35.8623], 8); // Lebanon's coordinates

    // Add tile layer from OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add marker on map click
    marker = L.marker([33.8547, 35.8623], { draggable: true }).addTo(map);

    // Handle marker dragend event
    marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        // Update marker position
        marker.setLatLng(position);
    });
}

// Function to close the map modal
function closeMapModal() {
    document.getElementById('mapModal').style.display = 'none';
}


// Function to select the location and update the input field
// Function to select the location and update the input field
function selectLocation() {
    // Close the modal
    closeMapModal();

    // Get the latitude and longitude of the selected location
    var position = marker.getLatLng();
    var latitude = position.lat;
    var longitude = position.lng;

    // Update the latitude and longitude display fields
    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;

    // Perform reverse geocoding to get the address and country information
    var url = 'https://nominatim.openstreetmap.org/reverse?lat=' + latitude + '&lon=' + longitude + '&format=json';

    // Fetch the address data from the Nominatim API
    fetch(url)
        .then(response => response.json())
        .then(data => {
            // Extract the country name from the address data
            var country = data.address.country;

            // Check if the selected location is outside Lebanon
            if (country !== 'Lebanon') {
                // If it's outside Lebanon, prompt the user to select a location inside Lebanon
                alert('Please select a location inside Lebanon.');
            } else {
                // If it's inside Lebanon, extract the city name from the address data
                var city = data.address.city;
                var locationName = city || data.display_name;
                // Use city name if available, otherwise use full address

                // Update the input field with the location name
                document.getElementById('locationInput').value = locationName.split(',').slice(0, -2).join(',');
            }
        })
        .catch(error => {
            console.error('Error fetching location data:', error);
        });
}
// Function to show calendar
function showCalendar() {
    const eventFields = document.getElementById('eventFields');
    if (document.getElementById('one').checked) {
        eventFields.style.display = 'block';
        document.getElementById('eventField').style.display = 'none';
    } else {
        eventFields.style.display = 'none';
    }
}

// Event listener for the "Once Time" radio button
document.getElementById('one').addEventListener('click', function() {
    showCalendar();
});

// Event listener for the event day input field
document.getElementById('eventDay').addEventListener('change', function() {
    // Get the selected event day
    var eventDay = document.getElementById('eventDay').value;
    // Get today's date
    var today = new Date().toISOString().slice(0, 10);
    // Compare the selected date with today's date
    if (eventDay < today) {
        // If the selected date is before today, display an alert
        alert('Please select an event day that is not before today.');
        // Clear the selection
        document.getElementById('eventDay').value = '';
    }
});


function showDays() {
    const eventField = document.getElementById('eventField');
    if (document.getElementById('always').checked) {
        eventField.style.display = 'block';
        document.getElementById('eventFields').style.display = 'none';
    } else {
        eventField.style.display = 'none';
    }
}
</script>
</body>
</html>
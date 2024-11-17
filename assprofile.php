<?php
include 'db_conn.php';
// Start the session
session_start();

// Initialize variables
$nameExists = false;
$showModal = false; // Initialize variable to control modal display

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $type = $_POST["type"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $rationfood = $_POST["rationfood"];
    $percent=$_POST["percent"];
    // Retrieve selected food types
    $foodTypes = isset($_POST["Meat"]) ? $_POST["Meat"] : "";
    $foodTypes .= isset($_POST["Sweet"]) ? " " . $_POST["Sweet"] : "";
    $foodTypes .= isset($_POST["Cooked"]) ? " " . $_POST["Cooked"] : "";
    $foodTypes .= isset($_POST["Baked"]) ? " " . $_POST["Baked"] : "";

    // Check if username is set in the session
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the phone number consists of 8 digits
        if (!preg_match('/^\d{8}$/', $phone)) {
            $showModal = true; // Set the flag to true to show the modal
        } else {
            // Check if the name already exists
            $sql_check = "SELECT * FROM association WHERE name = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("s", $name);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows > 0) {
                // Set the flag to true if the name exists
                $nameExists = true;
            } else {
                // Prepare SQL statement
                $sql_insert = "INSERT INTO association (username, name, type, address, phone, rationfood, foodtype,percent) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ssssisss", $username, $name, $type, $address, $phone, $rationfood, $foodTypes, $percent);


                // Execute SQL statement
                if ($stmt_insert->execute() === TRUE) {
                    echo "<p style='color: green; text-align: center;'>New record inserted successfully</p>";
                    header("Location: association.php");
                } else {
                    echo "<p style='color: red; text-align: center;'>Error: " . $sql_insert . "<br>" . $conn->error . "</p>";
                }
            }
        }

        // Close connections
        if (isset($stmt_check)) {
            $stmt_check->close();
        }
        $conn->close();
    } else {
        echo "Session username not set. Please log in."; // Redirect or handle accordingly
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        /* Close button */
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


        /* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    margin-left:314px;
    width: 50%;
    height: 50%;
    margin-top:180px;
    overflow: auto;
    background-color:transparent;     /* Black background with opacity */
}

/* Modal content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    height:33%; /* Could be more or less, depending on screen size */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); /* Box shadow */
}

/* Close button */
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

/* OK button */
button {
    background-color: #112546; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 5px;
    margin-left:220px;
}

button:hover {
    background-color: red; /* Darker green */
}

    </style>
</head>
<body>

    <div class="bg-association" style="height: 193vh;opacity:0.95;  background-image: linear-gradient(rgb(255, 42, 4),#152d53),url('as.jpg');">
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
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                        
                    <li><a href="logout.php">Log Out</a></li>
                    </ul>
                    <div class="menu-toggle"></div>
            
                </div>
            </div>
        </header>

        <section class="about">
            <div class="main">
                <div class="wrapper" style="width:700px;height:1030px;">
                    <form action="" method="POST">
                        <h1>Fill the information to help you</h1>
                        <div class="input-box" style="margin-left:180px;width:600px;">
                            <div class="input-field" style="height:60px; " >
                                <input type="text" placeholder="Name" style="font-weight:bold; font-size:25px;" name="name" required>
                                <i class='bx bx-user'></i>
                            </div>
                        </div>
                        <div class="input-box" style="margin-left:180px;width:600px;">
                            <div class="input-field" style="height:60px;" >
                                <select required style="width: 100%; height: 100%; background: transparent; border: 1px solid rgba(255,255,255,.2); outline: none; font-size: 25px; font-weight:bold; color: #fff; border-radius: 6px; padding: 15px 15px 15px 40px;" name="type">
                                    <option value="" disabled selected style="font-weight:bold;"> Association Type</option>
                                    <option value="infirmary" id="infirmary" name="infirmary" style="color:#fc3b00;font-weight:bold;">Infirmary</option>
                                    <option value="orphanage" id="orphanage" name="orphanage" style="color:#fc3b00;font-weight:bold;">Orphanage</option>
                                    <option value="handicapped" id="handicapped" name="handicapped" style="color:#fc3b00;font-weight:bold;">Care of Handicapped</option>
                                    <option value="charitypoor" id="charity" name="charity" style="color:#fc3b00;font-weight:bold;">Charity for Poor</option>
                                    <option value="scouts" id="scouts" name="scouts" style="color:#fc3b00;font-weight:bold;">Scouts</option>
                                    <option value="lunatics" id="lunatics" name="lunatics" style="color:#fc3b00;font-weight:bold;">Lunatics</option>
                                    <!-- Add more options as needed -->
                                </select>
                                <i class='bx bx-down-arrow'></i>
                            </div>
                        </div>
                        <div class="input-box" style="margin-left:180px;width:600px;">
                            <div class="input-field" style="height:60px;">
                                <input type="text" name="address" placeholder="Address" style="font-weight:bold;font-size:25px;" required>
                                <i class='bx bx-map'></i>
                            </div>
                        </div>
                        <div class="input-box" style="margin-left:180px;width:600px;">
                            <div class="input-field" style="height:60px;">
                                <input type="text" name="phone" placeholder="Phone Cell" style="font-weight:bold;font-size:25px;" required>
                                <i class='bx bx-phone'></i>
                            </div>
                        </div>
                        <div class="input-box" style="margin-left:180px;width:600px;">
                            <div class="input-field" style="height:60px;">
                                <input type="number" name="rationfood" placeholder="Food Rations" style="font-weight:bold;font-size:25px;" required>
                                <i class='bx bx-bowl-rice'></i>
                            </div>
                        </div>
                        <div class="input-box" style="margin-left:180px;width:600px;">
                            <div class="input-field" style=" width: 49%; height:120px; background: transparent; border: 2px solid rgba(255,255,255,.2); outline: none; font-size: 16px; color: #fff; border-radius: 6px; padding: 15px 15px 15px 40px;">
                                <label for="percent" style="font-weight:bold;font-size:21px;">Percentage of Need:</label>
                                <span id="percentDisplay" style="font-size:20px;color:white;">50</span>%
                                <input type="range" id="percent" style="margin-top:-25px;" name="percent" min="0" max="100" value="50" style="font-weight:bold;" required>
                              
                                <i style="margin-top:-20px;" class='bx bx-slider-alt' ></i>
                            </div>
                        </div>
                        
                        <div class="input-box" style="margin-left:180px;width:287px;">
                            <div class="input-field" style="width: 100%; height:250px; background: transparent; border: 2px solid rgba(255,255,255,.2); outline: none; font-size: 16px; color: #fff; border-radius: 6px; padding: 15px 15px 15px 40px;">
                                <label style="color:white;font-weight:bold;font-size: 23px;margin-left:10px;">Food Type:</label><br><br>
                                <i class='bx bx-bowl-hot' style="margin-top:-85px;font-size:25px;"></i>
                                <input type="checkbox" id="Meat" name="Meat" value="Meat" style="margin-top: -35px;height:20px;margin-left:-30px;">
                                <p style="margin-top:-25px;margin-left:23px;font-size:21px;">Meat</p><br>
                                <input type="checkbox" id="Sweet" name="Sweet" value="Sweet" style="margin-top: -30px;height:20px;margin-left:-20px;">
                                <p style="margin-top:-25px;margin-left:23px;font-size:21px;">Sweet</p><br>
                                <input type="checkbox" id="Cooked" name="Cooked" value="Cooked" style="margin-top: -5px;height:20px;margin-left:48px;">
                                <p style="margin-top:-25px;margin-left:23px;font-size:21px;">Cooked Food</p><br>
                                <input type="checkbox" id="Baked" name="Baked" value="Baked" style="margin-top: -5px;height:20px;margin-left:48px;">
                                <p style="margin-top:-25px;margin-left:23px;font-size:21px;">Baked Food</p><br>
                                <!-- Add more checkboxes as needed -->
                            </div>
                        </div>
                        
                        <button type="submit" class="btn" style="width:290px;margin-left:180px;">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
    
    <section class="footer" style="margin-top:3px;">
        <div class="foot">
            <div class="footer-content" >
                
                <div class="footlinks">
                    <h4 style="left: 10px;">Quick Links</h4>
                    <ul >
                        <li><a href="events.html">Add Event</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                </div>
    
                <div class="footlinks">
                    <h4 style="left: 60px;">Connect</h4>
                    <div class="social">
                        <a href="" target="_blank"><i class='bx bxl-facebook'></i></a>
                        <a href="" target="_blank"><i class='bx bxl-instagram' ></i></a>
                        <a href="" target="_blank"><i class='bx bxl-twitter' ></i></a>
                        
                        <a href="" target="_blank"><i class='bx bxl-youtube' ></i></a>
                       
                    </div>
                </div>
                
            </div>
        </div>
    
        <div class="end">
            <p>Tel:81/254271 Email: support@albaraka.com | Copyright © 2024 AlBaraka | All Rights Reserved. <br>Website developed by: Rouba Mohammad Ayach| Dr. Rami Safarjalani| </p>
        </div>
    </section>
    

    <!-- Modal for name already exists alert -->
    <div id="myModal" class="modal" <?php if ($nameExists) echo 'style="display:block"'; ?>>
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>The name already exists. Please choose a different name.</p>
            <button onclick="closeModal()">OK</button>
        </div>
    </div>

    <div id="phoneModal" class="modal" <?php if ($showModal) echo 'style="display:block"'; ?>>
    <div class="modal-content">
        <span class="close" onclick="closePhoneModal()">&times;</span>
        <p>Please enter a valid phone number consisting of 8 digits.</p>
        <button onclick="closePhoneModal()">OK</button>
    </div>
</div>

    <!-- JavaScript to handle modal behavior -->
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.querySelector(".modal-content .close");

        // When the user clicks on <span> (x) or the "OK" button, close the modal
        span.onclick = function() {
            closeModal();
        };

        // Function to close modal
        function closeModal() {
            modal.style.display = "none";
        }

        // Validation for phone number
        var phoneModal = document.getElementById("phoneModal");

       // Get the <span> element that closes the modal
        var phoneModalCloseBtn = phoneModal.querySelector(".modal-content .close");

       // When the user clicks on <span> (x) or the "OK" button, close the modal
         phoneModalCloseBtn.onclick = function() {
         closePhoneModal();
        };

       // Function to close phone modal
        function closePhoneModal() {
          phoneModal.style.display = "none";
        }
        
      // Get the range input element
      var percentInput = document.getElementById("percent");

// Get the span element to display the selected value
var percentDisplay = document.getElementById("percentDisplay");

// Function to update the value displayed next to the range slider
function updatePercentDisplay() {
    percentDisplay.textContent = percentInput.value; // Update the content with the selected value
    percentInput.style.setProperty('--value', percentInput.value / percentInput.max); // Set CSS custom property for styling
}

// Add event listener to update display when input changes
percentInput.addEventListener("input", updatePercentDisplay);

// Initial call to update display with default value
updatePercentDisplay();
 

    </script>



</html>

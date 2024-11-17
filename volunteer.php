<?php
// Establish a database connection
include("db_conn.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])){
    // Retrieve form data and sanitize
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $volunteeringtype = isset($_POST["volunteeringType"]) ? implode(",", $_POST["volunteeringType"]) : "";
   
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $days = isset($_POST["day"]) ? implode(",", $_POST["day"]) : "";
    // Assuming the username is provided in the form or any other source
    $freeday = isset($_POST["freeDay"]) ? $_POST["freeDay"] : "";

    // Check if the provided username exists in the signupvolun table
    $check_username_query = "SELECT * FROM signupvolun WHERE username = '$username'";
    $result = mysqli_query($conn, $check_username_query);

    if (mysqli_num_rows($result) == 0) {
        // Username does not exist in signupvolun table
        echo "Error: Username does not exist";
    } else {
        // Username exists, proceed with inserting into volunteers table
        // Construct INSERT query for volunteers table
        $sql = "INSERT INTO volunteers (username, fname, lname, phone,volunteeringtype,status,availableday,freeday) 
                VALUES ('$username', '$fname', '$lname', '$phone','$volunteeringtype','$status','$days','$freeday')";

        // Execute query
        if (mysqli_query($conn, $sql)) {
            header("Location: homevolun.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Close connection
    mysqli_close($conn);
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
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap&libraries=places" async defer></script>
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
                <li><a href="homevolun.php">My Profile</a></li>
                <li><a href="#" class="active">Volunteer</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
            <div class="menu-toggle"></div>
        </div>
    </div>

</header>

<div class="containerr" style="width:1250px;height:696px;">
    <div class="left" style="height:690px;"></div>
    <div class="right">
        <div class="formbox">
            <form id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                  onsubmit="return validateForm()">
                <h1>Sign Up</h1>
                <br><br>
                <p>Username</p>
            <input type="text" name="username" id="username" placeholder="Your username" required>

<br><br>
                <p>First Name</p>
                <input type="text" name="fname" id="fname" placeholder="your first name" required>
                <br><br><br>
                <p>Last Name</p>
                <input type="text" name="lname" id="lname" placeholder="your last name" required>
                <br><br><br>
                <p>Phone Cell</p>
                <input type="text" name="phone"  id="phone" placeholder="put your phone number" required>

                <div class="formboxxx" style="margin-top:-270px;margin-left:415px;margin-top:-410px;">

                    <p>Volunteering Type</p>
                    <br>
                    <input type="checkbox" id="agent" name="volunteeringType[]" value="Agent" style="margin-left:-40px;">
                    <label for="agent" >Agent</label><br>
                    <input type="checkbox" id="driver" name="volunteeringType[]" value="Driver" style="margin-left:-40px;">
                    <label for="driver">Driver</label><br>
                    <br><br>
                    <p>Status</p><br>
                    <input type="radio" id="always" name="status" value="always" onclick="showDays()" style="margin-left:-40px;" required>
                    <label for="always">Repetitive</label><br>
                    <input type="radio" id="one" name="status" value="one" onclick="showCalendar()" style="margin-left:-40px;" required>
                    <label for="one">Once Time</label><br>
                    <br><br>
                    <div id="freeday" style="display: none;margin-top: -30px;">
                        <p>Free Day</p>
                        <input type="date" id="freeDay" name="freeDay">
                    </div>
                    <br><br>
                    <div id="availibility" style="display: none;margin-top: -60px;">
                        <p>Availability Day</p>
                        <input type="checkbox"  name="day[]" value="monday" style="margin-left: -40px;">
                        <label for="monday">Monday</label><br>
                        <input type="checkbox" name="day[]" value="tuesday" style="margin-left: -40px;">
                        <label for="tuesday">Tuesday</label><br>
                        <input type="checkbox"  name="day[]" value="wednesday" style="margin-left:-40px;">
                        <label for="wednesday">Wednesday</label><br>
                        <input type="checkbox"  name="day[]" value="thursday" style="margin-left: -40px;">
                        <label for="thursday">Thursday</label><br>
                        <input type="checkbox"  name="day[]" value="friday" style="margin-left: -40px;">
                        <label for="friday">Friday</label><br>
                        <input type="checkbox"  name="day[]" value="saturday" style="margin-left: -40px;">
                        <label for="saturday">Saturday</label><br>
                        <input type="checkbox"  name="day[]" value="sunday" style="margin-left: -40px;">
                        <label for="sunday">Sunday</label><br>
                        <br>
                    </div>

                    <input type="submit" name="submit" value="Submit">
                </div>

            </form>
        </div>
    </div>
</div>


   <script>
    function validateForm() {
        // Validate phone number
        var phone = document.getElementById('phone').value;
        if (!(/^\d{8}$/.test(phone))) {
            alert('Please enter a valid phone number consisting of 8 digits.');
            return false;
        }

        // Validate at least one volunteering type is selected
        var volunteeringTypes = document.querySelectorAll('input[name="volunteeringType[]"]:checked');
        if (volunteeringTypes.length === 0) {
            alert('Please select at least one volunteering type.');
            return false;
        }

        // Validate based on selected status
        if (document.getElementById('always').checked) {
            // If "always" is checked, ensure at least one day is selected
            var daysChecked = document.querySelectorAll('input[name="day[]"]:checked').length;
            if (daysChecked === 0) {
                alert('Please select at least one day.');
                return false;
            }
        } else if (document.getElementById('one').checked) {
            // If "once" is checked, ensure event day input field is not empty and not before today
            var freeDay = document.getElementById('freeDay').value;
            if (freeDay === '') {
                alert('Please select an event day.');
                return false;
            }
            var today = new Date().toISOString().slice(0, 10);
            if (freeDay < today) {
                alert('Please select a Free Day that is not before today.');
                return false;
            }
        }

        return true;
    }

    function showCalendar() {
        const eventFields = document.getElementById('freeday');
        const availibility = document.getElementById('availibility');
        if (document.getElementById('one').checked) {
            eventFields.style.display = 'block';
            availibility.style.display = 'none';
        } else {
            eventFields.style.display = 'none';
            availibility.style.display = 'block';
        }
    }

    function showDays() {
        const eventField = document.getElementById('availibility');
        const freeDay = document.getElementById('freeday');
        if (document.getElementById('always').checked) {
            eventField.style.display = 'block';
            freeDay.style.display = 'none';
        } else {
            eventField.style.display = 'none';
            freeDay.style.display = 'block';
        }
    }
</script>
</body>
</html>


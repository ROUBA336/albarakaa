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
    <style>
    .day-checkbox {
        display: inline-block;
        margin-right: 10px;
    }

    .day-checkbox input[type="checkbox"] {
        display: none;
    }

    .day-checkbox label {
        position: relative;
        display: inline-block;
        padding-left: 30px;
        cursor: pointer;
    }

    .day-checkbox label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 2px;
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
    }

    .day-checkbox input[type="checkbox"]:checked + label:before {
        background-color: #ff4a04;
        border-color: #ff4a04;
    }

    .day-checkbox label:after {
        content: '';
        position: absolute;
        left: 7px;
        top: 6px;
        width: 6px;
        height: 10px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        opacity: 0;
    }

    .day-checkbox input[type="checkbox"]:checked + label:after {
        opacity: 1;
    }

    .day-checkbox label span {
        display: inline-block;
        margin-left: 5px;
    }
</style>



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
                <li><a href="#" class="active">Update your Profile</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
            <div class="menu-toggle"></div>
        </div>
    </div>

</header>

<div class="containerr" style="width:700px;height:665px;border-radius:20px; border:1px solid transparent;background: #152d53;opacity:0.9;">
   

        <div class="formbox"  style="background:transparent;text-align:center; ">
            <form id="myForm" action="updatevolunn.php" method="POST"
                  onsubmit="return validateForm()">
                <h1 style="color:white;margin-top:-40px;">Update Your Profile</h1>
                <br>
 
      
               
                <p  style="margin-left:-190px;color:white">First Name</p>
            <input style="width:300px;font-size:24px;" type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($volunteer_details['fname']); ?>" placeholder="Your first name" required>
            <br><br>
            <p  style="margin-left:-190px;color:white">Last Name</p>
            <input  style="width:300px;font-size:24px;;"type="text" name="lname" id="lname" value="<?php echo htmlspecialchars($volunteer_details['lname']); ?>" placeholder="Your last name" required>
            <br><br>
            <p  style="margin-left:-190px;color:white">Phone Cell</p>
            <input  style="width:300px;font-size:24px;" type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($volunteer_details['phone']); ?>" placeholder="Your phone number" required>
            <br><br>

            <?php if ($volunteer_details['status'] === 'one') : ?>
                <p  style="margin-left:-190px;color:white">Free Day</p>
                <input style="width:300px;font-size:24px;" type="date" name="freeday" id="freeday" value="<?php echo htmlspecialchars($volunteer_details['freeday']); ?>" placeholder="Your free day" required>
                <br><br>
            <?php endif; ?>

          <!-- Available Days -->
          <?php if ($volunteer_details['status'] === 'always') : ?>
                <p style="margin-left:-150px;color:white">Available Days</p><br>
                <div class="day-checkbox" style="margin-left:100px;">
                    <input type="checkbox" name="available_days[]" id="monday" value="monday" <?php echo (in_array('monday', explode(',', $volunteer_details['availableday']))) ? 'checked' : ''; ?>>
                    <label for="monday" style="color:white;">Monday</label>
                </div>
                <div class="day-checkbox">
                    <input type="checkbox" name="available_days[]" id="tuesday" value="tuesday" <?php echo (in_array('tuesday', explode(',', $volunteer_details['availableday']))) ? 'checked' : ''; ?>>
                    <label for="tuesday" style="color:white;">Tuesday</label>
                </div>
                <div class="day-checkbox">
                    <input type="checkbox" name="available_days[]" id="wednesday" value="wednesday" <?php echo (in_array('wednesday', explode(',', $volunteer_details['availableday']))) ? 'checked' : ''; ?>>
                    <label for="wednesday" style="color:white;">Wednesday</label>
                </div>
                <br><br>
                <div class="day-checkbox" style="margin-left:170px;">
                    <input type="checkbox" name="available_days[]" id="thursday" value="thursday" <?php echo (in_array('thursday', explode(',', $volunteer_details['availableday']))) ? 'checked' : ''; ?>>
                    <label for="thursday" style="color:white;">Thursday</label>
                </div>
                <div class="day-checkbox">
                    <input type="checkbox" name="available_days[]" id="friday" value="friday" <?php echo (in_array('friday', explode(',', $volunteer_details['availableday']))) ? 'checked' : ''; ?>>
                    <label for="friday" style="color:white;">Friday</label>
                </div>
                <div class="day-checkbox">
                    <input type="checkbox" name="available_days[]" id="saturday" value="saturday" <?php echo (in_array('saturday', explode(',', $volunteer_details['availableday']))) ? 'checked' : ''; ?>>
                    <label for="saturday" style="color:white;">Saturday</label>
                </div>
                <div class="day-checkbox">
                    <input type="checkbox" name="available_days[]" id="sunday" value="sunday" <?php echo (in_array('sunday', explode(',', $volunteer_details['availableday']))) ? 'checked' : ''; ?>>
                    <label for="sunday" style="color:white;">Sunday</label>
                </div>
<?php endif; ?><br><br><br>
                    <input style="" type="submit" name="submit" value="Update">
                </div>

            </form>
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

    

        // Validate based on selected status
   
    }

   
</script>
</body>
</html>



<?php
include 'db_conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginvolunteer.php");
    exit();
}

// Retrieve the event ID from the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Now you can use $event_id to fetch the event details from the database
    // Query to retrieve event details based on $event_id
    $event_query = "SELECT * FROM eventt WHERE eid = '$event_id'";

    // Execute the query
    $event_result = mysqli_query($conn, $event_query);

    // Check if the query was successful
    if (!$event_result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Fetch event details
    $event_details = mysqli_fetch_assoc($event_result);

    // Now you can use $event_details to populate your form fields for updating
} else {
    // If event ID is not provided in the URL, redirect back to the main profile page
    header("Location: homeevent.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Your Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body style="background-color:#ddd;">
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
                <li><a href="#" class="active">Update your Profile</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
            <div class="menu-toggle"></div>
        </div>
    </div>
</header>

<div class="container" style="width:800px;height:600px;margin-top:40px;border-color:red; box-shadow: 10px 5px 10px rgba(255, 210, 193, 0.932);">
    <div class="formbox">
        <form id="myForm" action="updateeventt.php" method="POST" onsubmit="return validateForm()">
        <input type="hidden" name="event_id" value="<?php echo $event_details['eid']; ?>">

            <h1 style="margin-left:30px;">Update Your Profile</h1>
            <br><br>
            <div class="formboxxx" style="margin-left:270px;margin-top:-20px;">
                <p style="font-family:monospace;font-size:27px;" >Food Items</p>
                <input type="checkbox" id="meat" name="fooditem[]" value="Meat" <?php if(in_array("Meat", explode(", ", $event_details['fooditem']))) echo "checked"; ?> style="margin-left:-130px;">
                <label for="meat" style="margin-left:-140px;">Meat</label><br>
                <input type="checkbox" id="baked" name="fooditem[]" value="Baked" <?php if(in_array("Baked", explode(", ", $event_details['fooditem']))) echo "checked"; ?> style="margin-left:-130px;">
                <label for="baked" style="margin-left:-140px;">Baked Goods</label><br>
                <input type="checkbox" id="cooked" name="fooditem[]" value="Cooked" <?php if(in_array("Cooked", explode(", ", $event_details['fooditem']))) echo "checked"; ?> style="margin-left:-130px;">
                <label for="cooked"  style="margin-left:-140px;">Cooked Food</label><br>
                <input type="checkbox" id="sweet" name="fooditem[]" value="Sweet" <?php if(in_array("Sweet", explode(", ", $event_details['fooditem']))) echo "checked"; ?> style="margin-left:-130px;">
                <label for="sweet" style="margin-left:-140px;">Sweet</label><br>
                <br>
                <p style="font-family:monospace;font-size:27px;">Time of Delivery</p>
                <input type="time" name="deliverytime" id="deliverytime" value="<?php echo htmlspecialchars($event_details['deliverytime']); ?>" style="width:50%;">
                <br><br>
                <p style="font-family:monospace;font-size:27px;">Phone</p>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($event_details['phone']); ?>" style="width:50%;">
                <br><br><br><br>
                <input type="submit" name="submit" value="Save Changes" style="margin-left:-30px;">
            </div>
        </form>
    </div>
</div>

<script>
    function validateForm() {
        // Add your validation logic here if needed
        return true;
    }
</script>
</body>
</html>

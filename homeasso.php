<?php 
    session_start();

    // Include database connection
    include("db_conn.php");

    // Redirect to login page if user is not logged in
    if(!isset($_SESSION['username'])){
        header("Location: association.php");
        exit();
    }

    // Retrieve user information
    $username = $_SESSION['username'];
    $query = "SELECT * FROM association WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $association_info = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>/* Reset default margin and padding */
/* Reset default margin and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #ddd;
    color: #333;
    height:900px;
}
.btn {
    background-color: #ff4a04;
    color: #fff;
    padding: 15px 30px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #ff6e3d;
}
/* Header styles */
.header-area {
    background-color: #152d53;
    color: #fff;
    padding: 20px;
    text-align: center;
}

.site-logo a {
    color: #fff;
    text-decoration: none;
    font-size: 36px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Profile info styles */
.profile-info {
    background-color: #fff;
    padding: 40px;
    margin: 20px auto;
    max-width: 900px;
    border-radius: 20px;
    position: relative; /* Set position relative for pseudo-element */
    overflow: hidden; /* Hide overflowing part of the border animation */
    border: 3px solid transparent;
    border-radius:20px; /* Set initial transparent border */
}

/* Animation for border */
.profile-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius:20px;
    box-sizing: border-box;
    border: 4px solid #fc3b00; /* Initial border color */
    animation: flowBorder 4s linear infinite; /* Animation for border */
}

/* Keyframes for border animation */
@keyframes flowBorder {
    0% {
        border-width: 4px;
        border-radius:20px;
        border-top-color: #fc3b00;
        border-right-color: #152d53;
        border-bottom-color: #152d53;
        border-left-color: #152d53;
    }
    25% {
        border-width: 4px;
        border-top-color: #152d53;
        border-right-color: #fc3b00;
        border-bottom-color:#fc0000;
        border-left-color: #152d53;
    }
    50% {
        border-width: 4px;
        border-top-color: #152d53;
        border-right-color: #152d53;
        border-bottom-color: #fc3b00;
        border-left-color: #fc0000;
    }
    75% {
        border-width: 4px;
        border-top-color: #152d53;
        border-right-color:#fc0000;
        border-bottom-color: #152d53;
        border-left-color: #fc3b00;
    }
    100% {
        border-width: 4px;
        border-top-color: #fc3b00;
        border-right-color:#fc0000;
        border-bottom-color: #152d53;
        border-left-color:#152d53;
    }
}


 
.profile-info h2 {
    color: #152d53;
    font-size: 36px;
    margin-bottom: 30px;
    text-align: center;
}

.profile-info p {
    font-size: 20px;
    margin-bottom: 20px;
    line-height: 1.6;
}

/* Button styles */
.btn {
    background-color: #ff4a04; /* Button background color */
    color: #fff; /* Button text color */
    padding: 15px 30px; /* Padding around the button text */
    border: none; /* Remove button border */
    border-radius: 30px; /* Rounded border */
    cursor: pointer; /* Cursor style */
    font-size: 20px; /* Button text size */
    text-transform: uppercase; /* Uppercase button text */
    letter-spacing: 1px; /* Spacing between button text */
    transition: background-color 0.3s ease; 
    margin-top:-400px;/* Smooth transition effect for background color */
}

.btn:hover {
    background-color: #ff6e3d; /* Change background color on hover */
}


/* Footer styles */
.footer {
    background-color: #152d53;
    color: #fff;
    padding: 40px 0;
    text-align: center;
}

.footer p {
    font-size: 18px;
    margin-bottom: 10px;
}

.footer a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.footer a:hover {
    color: #ff4a04;
}


</style>
</head>
<body>
    <header class="header-area">
        <div class="header-container">
            <div class="site-logo">
                <a href="#">AL<span>BARAKA</span></a>
                <a href="" style="font-size:30px;font-weight:bold;margin-left:170px;">Welcome <b style="color:#ff4a04;font-family: cursive;font-size:35px;"><?php echo $association_info['username']; ?></b></a>
            </div>
            <div class="mobile-nav">
                <i class="fas fa-bars"></i>
            </div>
            <div class="site-nav-menu">
                <ul class="primary-menu">
                    <li><a href="#" class="active">My Profile</a></li>
                  
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
                <div class="menu-toggle"></div>
            </div>
        </div>
    </header>
    
    <form action="updateasso.php" method="post">
    <div class="profile-info">
        <?php if(isset($association_info['name'])): ?>
            <p><strong style="font-size:32px;color:#152d53; font-family: math;">Name:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 30px;font-family:cursive;margin-left:50px;"> <?php echo $association_info['name']; ?></span></p>
            <hr><br>
        <?php endif; ?>

        <?php if(isset($association_info['type'])): ?>
            <p><strong style="font-size:32px;color:#152d53; font-family: math;">Type:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size: 30px;font-family:cursive;margin-left:30px;"> <?php echo $association_info['type']; ?></span></p>
            <hr><br>
        <?php endif; ?>

        <?php if(isset($association_info['address'])): ?>
            <p><strong style="font-size:32px;color:#152d53; font-family: math;">Address:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 30px;font-family:cursive;margin-left:0px;">  <?php echo $association_info['address']; ?></span></p>
            <hr><br>
        <?php endif; ?>

        <?php if(isset($association_info['phone'])): ?>
            <p><strong style="font-size:32px;color:#152d53; font-family: math;">Phone:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 30px;font-family:cursive;margin-left:40px;">  <?php echo $association_info['phone']; ?></span></p>
            <hr><br>
        <?php endif; ?>

        <?php if(isset($association_info['rationfood'])): ?>
            <p><strong style="font-size:32px;color:#152d53; font-family: math;">Ration Food:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 30px;font-family:cursive;margin-left:40px;"> <?php echo $association_info['rationfood']; ?></span></p>
            <hr><br>
        <?php endif; ?>

        <?php if(isset($association_info['foodtype'])): ?>
            <p><strong style="font-size:32px;color:#152d53; font-family: math;">Food Type:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 30px;font-family:cursive;margin-left:0px;"> <?php echo $association_info['foodtype']; ?></span></p>
            <hr><br>
        <?php endif; ?>
    </div>
    <input type="submit" class="btn" style="margin-left:950px;" value="Update Profile">
</form>


</body>
</html>

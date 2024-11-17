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
    <title>Volunteer Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #162f57;
        }
        

        .header-area {
            background-color: #162f57;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .site-logo a {
            color: white;
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 800px;
            height:750px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px  rgba(255, 72, 0, 0.932);
            margin-top: 30px;
            
        }

        .profile-info {
            margin-bottom: 20px;
           
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 18px;
            line-height: 1.6;
        }

        .logout-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff4a04;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .logout-link:hover {
            background-color: #ff6c3d;
        }

        .box {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            width:700px;
            margin-left:320px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .update-button {
    display: inline-block;
    padding: 10px 20px;
    margin-left:310px;
 
    background-color: #162f57;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
}

.update-button:hover {
    background-color: #ff4a04;
}

    </style>
</head>
<body>
    <header class="header-area">
        <div class="header-container">
            <div class="site-logo">
                <a href="#" style="font-size:40px;">AL<span>BARAKA</span></a>
                <a href="#" style="font-size:30px;font-weight:bold;margin-left:600px;"><strong style="color:white;">Welcome</strong> <b style="color:#ff4a04;font-family: cursive;font-size:39px;"><?php echo $username; ?></b></a>
            </div>
            <div class="mobile-nav">
                <i class="fas fa-bars"></i>
            </div>
            <div class="site-nav-menu">
                <ul class="primary-menu">
                <li><a href="profileevolun.php" class="active">My Profile</a></li>
                    <li><a href="homevolun.php" >Requests</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
                <div class="menu-toggle"></div>
            </div>
        </div>
    </header>
  
    <main>
        <form action="updatevolun.php" method="POST">
      

        <div class="container" style="width:1349px;">
            <br>
            
            <div class="profile-info">
                <h2 style="text-align:center;font-family:cursive;font-size:32px;">Personal Information</h2><br>
             

                <p style="margin-left:244px;"><strong style="font-family:serif;font-size:25px;">First Name:</strong> <span style="color: rgba(255, 72, 0, 0.932);font-family:cursive;font-size:32px;"><?php echo htmlspecialchars($volunteer_details['fname']); ?></span></p>
                <p style="margin-left:244px;" ><strong style="font-family:serif;font-size:25px;">Last Name:</strong> <span style="color: rgba(255, 72, 0, 0.932);font-family:cursive;font-size:32px;"> <?php echo htmlspecialchars($volunteer_details['lname']); ?></span></p>
                <p style="margin-left:244px;"><strong style="font-family:serif;font-size:25px;">Phone Cell:</strong> <span style="color: rgba(255, 72, 0, 0.932);font-family:cursive;font-size:32px;"> <?php echo htmlspecialchars($volunteer_details['phone']); ?></span></p>
                <br>
                <hr>
                <br>
                <h2 style="text-align:center;font-family:cursive;font-size:32px;">Volunteering Information</h2><br>
               
                <p style="margin-left:244px;"><strong style="font-family:serif;font-size:25px;">Volunteering Type:</strong><span style="color: rgba(255, 72, 0, 0.932);font-family:cursive;font-size:32px;">  <?php echo htmlspecialchars($volunteer_details['volunteeringtype']); ?></span></p>
                <p style="margin-left:244px;"><strong style="font-family:serif;font-size:25px;">Status:</strong><span style="color: rgba(255, 72, 0, 0.932);font-family:cursive;font-size:32px;">  <?php echo htmlspecialchars($volunteer_details['status']); ?></span></p>
                <?php if (!empty($volunteer_details['availableday'])): ?>
                        <p style="margin-left:244px;">
                            <strong style="font-family:serif;font-size:25px;">Available Day:</strong>
                            <span style="color: rgba(255, 72, 0, 0.932);font-family:cursive;font-size:30px;">
                                <?php echo htmlspecialchars($volunteer_details['availableday']); ?>
                            </span>
                        </p>
                    <?php endif; ?>
                    <!-- Check and display "Free Day" if not empty -->
                    <?php if ($volunteer_details['freeday'] !== '0000-00-00'): ?>
                    <p style="margin-left:244px;">
                        <strong style="font-family:serif;font-size:25px;">Free Day:</strong>
                        <span style="color: rgba(255, 72, 0, 0.932);font-family:cursive;font-size:30px;">
                            <?php echo htmlspecialchars($volunteer_details['freeday']); ?>
                        </span>
                    </p>
                <?php endif; ?>

            </div>
            <br>
            <button class="update-button" type="submit" name="submit" id="submit">Update Profile</button>
            <!-- Add hidden input fields to pass necessary data to updatevolun.php -->
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($volunteer_details['username']); ?>">
        </div>
    </main>
    <br><br><br>
    <br>
</form>
</body>
</html>

<?php 
    session_start();

    // Include database connection
    include("db_conn.php");

    // Redirect to login page if user is not logged in
    if(!isset($_SESSION['username'])){
        header("Location: adminprofile.php");
        exit();
    }

    // Fetch the number of events
    $events_query = "SELECT COUNT(*) AS num_events FROM eventt";
    $events_result = mysqli_query($conn, $events_query);
    $num_events = mysqli_fetch_assoc($events_result)['num_events'];

    // Fetch the number of volunteers
    $volunteers_query = "SELECT COUNT(*) AS num_volunteers FROM volunteers";
    $volunteers_result = mysqli_query($conn, $volunteers_query);
    $num_volunteers = mysqli_fetch_assoc($volunteers_result)['num_volunteers'];

    // Fetch the number of associations
    $associations_query = "SELECT COUNT(*) AS num_associations FROM association";
    $associations_result = mysqli_query($conn, $associations_query);
    $num_associations = mysqli_fetch_assoc($associations_result)['num_associations'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin Dashboard | Keyframe Effects</title>
    <link rel="stylesheet" href="admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
                       <a href="admin.php" class="active">
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
                        <a href="adminevent.php">
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
                        <a href="adminassociation.php" >
                            <span class="las la-home"></span>
                            <small>Associations</small>
                        </a>
                    </li>
                    <li>
                        <a href="a.php" >
                            <span class="lab la-autoprefixer"></span>
                            <small>Always </small>
                        </a>
                    </li>

                    <li>
                        <a href="a.php"  >
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
                    <span class="las la-bars" style="font-size:30px;"></span>
                </label>
                
                <div class="header-menu">
                  
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <i class='bx bx-power-off' style="color: orangered;font-size:25px;"></i>
                        <a href="logout.php" style="font-size: 30px; color: orangered;">Logout</a>
                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header" style="color:#162f57;">
                <h1>Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>
            
            <div class="page-content">
            
                <div class="analytics">

                    <div class="card" style="margin-left:90px;width:250px;">
                        <div class="card-head">
                        <h2 style="color:#162f57;"><?php echo $num_events; ?></h2>
                            <i class='bx bx-party'></i>
                        </div>
                        <div class="card-progress">
                            <h3 style="color:#162f57;">Number of Events</h3>
                          
                        </div>
                    </div>

                    <div class="card" style="margin-left:100px;width:250px;">
                        <div class="card-head">
                            <h2 style="color:#162f57;"><?php echo $num_associations; ?></h2>
                            <i class='bx bx-group'></i>
                        </div>
                        <div class="card-progress">
                            <h3 style="color:#162f57;">Number of Associations</h3>
                          
                        </div>
                    </div>

                    <div class="card" style="margin-left:90px;width:250px;">
                        <div class="card-head">
                        <h2 style="color:#162f57;"><?php echo $num_volunteers; ?></h2>
                            <i class='bx bx-user-voice'></i>
                        </div>
                        <div class="card-progress">
                            <h3 style="color:#162f57;">Number of Volunteer</h3>
                           
                        </div>
                    </div>

             
                </div>


            
                </div>
            
            </div>
            
        </main>
        
    </div>

</body>
</html>
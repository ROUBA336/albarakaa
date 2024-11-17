<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin Dashboard | Keyframe Effects</title>
    <link rel="stylesheet" href="admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        table {
            width:1170px;
            border-collapse: collapse;
            margin-top: 0px;
           margin-left:-10px;
        }
        th, td {
            width:700px;
            border: 3px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ff4a04;
            color:white;
            text-align:center;
            font-size:21px;
            width:200px;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        td{
            color:#152d53;
            font-size:20px;
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
                       <a href="admin.php" >
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
                        <a href="adminassociation.php">
                            <span class="las la-home"></span>
                            <small>Associaations</small>
                        </a>
                    </li>
                    <li>
                        <a href="a.php" class="active" >
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
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <i class='bx bx-power-off' style="color: orangered;"></i>
                        <a href="logout.php" style="font-size: 20px; color: orangered;">Logout</a>
                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1 style="color:#152d53;">Details of all associations that assigned by always events</h1>
               
            </div>
            <?php
            // Include database connection
            include("db_conn.php");

            // Fetch all association details
            $sql = "SELECT * FROM association";
            $result = mysqli_query($conn, $sql);

            // Check if there are any associations
            if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="page-content">
            
                <div class="analytics" style="height:400px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Event / Phone</th>
                                
                                <th>Association / Phone</th>
                              
                                <th>Volunteer / Phone</th>
                               
                                <th>Assistant / Phone</th>

                                <th>Day(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    // Start session

    // Fetch event name, event phone, association name, association phone, volunteer name, and assistant name of the event from the alwaysasso table
    $event_query = "SELECT eventt.eventname, eventt.phone  AS event_phone,eventt.days AS days, association.name AS association_name, association.phone AS association_phone,
        CONCAT(volunteers.fname, ' ', volunteers.lname,'(', volunteers.phone, ') ') AS volunteer_name,
        CONCAT( volunteers.fname, ' ', volunteers.lname,'(', volunteers.phone, ') ') AS volunteer_info,
        CONCAT(assistantVol.fname, ' ', assistantVol.lname) AS assistant_name,
        CONCAT( assistantVol.fname, ' ', assistantVol.lname,'(', assistantVol.phone, ') ') AS assistant_info
        FROM alwaysasso 
        INNER JOIN eventt ON alwaysasso.eid = eventt.eid 
        INNER JOIN association ON alwaysasso.aid = association.aid
        LEFT JOIN driver ON alwaysasso.eid = driver.eid
        LEFT JOIN volunteers ON driver.vid = volunteers.vid
        LEFT JOIN assistant ON alwaysasso.eid = assistant.eid
        LEFT JOIN volunteers AS assistantVol ON assistant.vid = assistantVol.vid";
    $event_result = mysqli_query($conn, $event_query);

    // Check if events are found
    if (mysqli_num_rows($event_result) > 0) {
        // Output data of each event
        while ($row = mysqli_fetch_assoc($event_result)) {
            echo "<tr>";
            echo "<td>" . $row['eventname'] . " (" . $row['event_phone'] . ")</td>"; // Display event name and phone number
            
            echo "<td>" . $row['association_name'] . " (" . $row['association_phone'] . ")</td>"; // Display association name and phone number
            echo "<td>" . $row['volunteer_info'] . "</td>"; // Display volunteer name and phone number
            echo "<td>" . $row['assistant_info'] . "</td>"; // Display assistant name and phone number
            echo "<td>" . $row['days'] ."</td>";
            echo "</tr>";
        }
    } else {
        // No events found
        echo "<tr><td colspan='4'>No events found.</td></tr>";
    }
?>

                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                // No associations found
                echo "<div class='container'>No associations found.</div>";
            }

            // Close database connection
            mysqli_close($conn);
            ?>
            </div>
        </main>
    </div>
</body>
</html>

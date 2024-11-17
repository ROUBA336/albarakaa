
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
    <style>
    .orange-text {
    color: #ff4a04;
    font-size:20px;
    font-weight:bold;
}
th{
    color: #ff4a04;
    font-size:22px;
    text-align:center;
}
td{
    text-align:center;
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
                        <a href="adminevent.php" >
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
                        <a href="adminassociation.php" class="active">
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
            <h1>Associations</h1>
        </div>
        <div class="container">
            <?php
            // Include database connection
            include("db_conn.php");

            // Fetch all association details
            $sql = "SELECT * FROM association";
            $result = mysqli_query($conn, $sql);

            // Check if there are any associations
            if (mysqli_num_rows($result) > 0) {
            ?>
                <div class="container">
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th>Name</th>
                                <th>Type</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Nb Ration</th>
                                <th>Food</th>
                                <th>Needed</th>
                                <th>Delete</th>
                                <!-- Add more columns if needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Output data of each association
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                
                                echo "<td style='color:#152d53;font-size:21px;'>" . $row['name'] . "</td>";
                                echo "<td style='color:#152d53;font-size:21px;'>" . $row['type'] . "</td>";
                                echo "<td style='color:#152d53;font-size:21px;'>" . $row['address'] . "</td>";
                                echo "<td style='color:#152d53;font-size:21px;'>" . $row['phone'] . "</td>";
                                echo "<td style='color:#152d53;font-size:21px;'>" . $row['rationfood'] . "</td>";
                                
                                echo "<td style='color:#152d53;font-size:21px;'>" . $row['foodtype'] . "</td>";
                                echo "<td style='color:#152d53;font-size:21px;'>" . $row['percent'] . "%" . "</td>";

                                echo "<td><form method='post' action='delete_association.php'>";
                                echo "<input type='hidden' name='association_id' value='" . $row['aid'] . "'>";
                                echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                echo "</form></td>";
 
                                // Add more columns if needed
                                echo "</tr>";
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
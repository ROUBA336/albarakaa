<?php 
    session_start();

    // Include database connection
    include("db_conn.php");

    // Redirect to login page if user is not logged in
    if(!isset($_SESSION['username'])){
        header("Location: association.php");
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_changes'])) {
        // Retrieve updated information from the form
        $name = $_POST['name'];
        
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $rationfood = $_POST['rationfood'];
        // Combine selected food types into a comma-separated string
       

        // Retrieve the username from the session
        $username = $_SESSION['username'];

        // Update the association information in the database
        $query = "UPDATE association SET name='$name', address='$address', phone='$phone', rationfood='$rationfood' WHERE username='$username'";
        $result = mysqli_query($conn, $query);

        // Check if the update was successful
        if ($result) {
            // Redirect to the home page with a success message
            header("Location: homeasso.php");
            exit();
        } else {
            // Redirect back to the profile page with an error message
            header("Location: updateasso.php");
            exit();
        }
    }

    // Retrieve user information if not submitted or redirect if not logged in
    $username = $_SESSION['username'];
    $query = "SELECT * FROM association WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $association_info = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
      
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(45deg, #11213b,red);
    border: 2px solid rgba(255,255,255,.2);
    box-shadow: 0 0 10px rgba(0, 0, 0, .2);
    margin: 0;
    padding: 0;
}



h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form {
            max-width: 500px;
            margin: 100px auto; /* Center the form horizontally and vertically */
            padding: 40px 35px 55px;
            margin-top:40px;
            background: white;
            border: 2px solid red;
            box-shadow:0 0 25px red;
    backdrop-filter:blur(50px);
    border-radius: 10px;
    backdrop-filter:blur(50px);
    border-radius: 10px;
    color: #fc3b00;
   
        }


.profile-info {
    margin-bottom: 50px;
   
}

.profile-info p {
    margin-bottom: 10px;
    color: #555;
}

.profile-info p input[type="text"],
.profile-info p input[type="number"] {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.profile-info p input[type="text"]:focus,
.profile-info p input[type="number"]:focus {
    border-color: #007bff;
    outline: none;
}

.btn {
    background-color:#142440;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 12px 20px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

.btn-cancel {
    background-color: #dc3545;
}

.btn-cancel:hover {
    background-color: #fc0000;
}

.btn-group {
    display: flex;
    justify-content: space-between;
}
    </style>
</head>
<body>
    
    <!-- Your HTML body content -->
    <form action="updateasso.php" method="post">
        <div class="profile-info">
            <!-- Display current profile information -->
            <p style="color:#142440"><strong style="font-size:21px;">Name:</strong> &nbsp;<input type="text" name="name" style="color:#152d53;font-family:cursive;" value="<?php echo $association_info['name']; ?>"></p>
            <p style="color:#142440"><strong style="font-size:21px;">Address:</strong> <input type="text" style="color:#152d53;font-family:cursive;"  name="address" value="<?php echo $association_info['address']; ?>"></p>
            <p style="color:#142440"><strong style="font-size:21px;">Phone:</strong> <input type="text"  style="color:#152d53; font-family:cursive;"  name="phone" value="<?php echo $association_info['phone']; ?>"></p>
            <p style="color:#142440"><strong style="font-size:21px;">Ration Food:</strong> <input type="number" style="color:#152d53;font-family:cursive;"  name="rationfood" value="<?php echo $association_info['rationfood']; ?>"></p>
           
        </div>
        <div class="btn-group">
                <input type="submit" class="btn" value="Save Changes" name="save_changes">
                <button type="button" class="btn btn-cancel" onclick="window.location.href='homeasso.php'">Cancel</button>
            </div>
    </form>
</body>
</html>

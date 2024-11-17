
<?php
// Database connection
include 'db_conn.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the admin table
$sql = "SELECT * FROM admin";
$result = $conn->query($sql);

// Check if there is any data
if ($result->num_rows > 0) {
    // Fetching data row by row
    $row = $result->fetch_assoc();
} else {
    echo "0 results";
}
$birthdate = $row['bdate']; // Assuming 'bdate' is the column name for the birthdate field

// Format the birthdate using PHP
$formattedBirthdate = date('Y-m-d', strtotime($birthdate));

$conn->close();

?>



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
                       <a href="updateprofile.php" class="active">
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
                <h1>Profile</h1>
                <h3>Update Profile</h3>
            </div>
            
            
            
        </main>
        
    </div>


    <div class="container light-style flex-grow-1 container-p-y" style="margin-left: 400px;margin-top: 14px;width: 700px;">
      
        <div class="card overflow-hidden" style="border-color: transparent;border-width: 5px;  box-shadow: 0px 0px 7px 3px orangered;">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links" style="margin-top: 20px;" >
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Info</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-social-links">Social links</a>
                      
                    </div>
                </div>
                <form action="update_admin.php" method="POST">
                <div class="col-md-4" style="margin-left: 300px; margin-top: -216px;">
           
                    <div class="tab-content">
                        
                    <div class="tab-pane fade active show" id="account-general">
                  
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">First name</label>
                                    <input type="text" id="firstName" name="firstName" class="form-control mb-1" value="<?php echo $row['fname']; ?>" style="box-shadow: 0px 0px 3px 1px orangered;">

                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last name</label>
                                    <input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $row['lname']; ?>" style=" box-shadow: 0px 0px 3px 1px orangered;" value="Ayach">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" id="email" name="email" class="form-control mb-1" value="<?php echo $row['email']; ?>" style=" box-shadow: 0px 0px 3px 1px orangered;" value="support@albaraka.com">
                                   
                                </div>
                               
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Current password</label>
                                    <input type="password" id="password" name="password" readonly value="<?php echo $row['pswd']; ?>" class="form-control" style=" box-shadow: 0px 0px 3px 1px orangered;">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New password</label>
                                    <input type="password"  id="newPassword" name="newPassword"   class="form-control" style=" box-shadow: 0px 0px 3px 1px orangered;">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Repeat new password</label>
                                    <input type="password"  id="repeatPassword" name="repeatPassword" class="form-control" style=" box-shadow: 0px 0px 3px 1px orangered;">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                                
                                <div class="form-group">
                                    
                                   
                                        <label for="birthday">Birthday:</label></br>
                                        <input type="date" id="birthday" id="birthday" name="birthday" value="<?php echo $row['bdate']; ?>" name="birthday" style="width: 170px;border-color:transparent;box-shadow:  0px 0px 3px 1px orangered;">
                                       

                                </div>
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <select class="custom-select" id="country" name="country" value="<?php echo $row['country']; ?>" style=" box-shadow: 0px 0px 3px 1px orangered;">
                                        <option>USA</option>
                                        <option selected>Canada</option>
                                        <option>UK</option>
                                        <option>Germany</option>
                                        <option>Lebanon</option>
                                        <option>Saudi Arabia</option>
                                        <option>Turkiye</option>
                                        <option>Kuwait</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                              
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $row['phone']; ?>"value="+961 81254271"  style=" box-shadow: 0px 0px 3px 1px orangered;">
                                </div>
                           
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-social-links">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" id="twitter" name="twitter" class="form-control" value="<?php echo $row['twitter']; ?>" style=" box-shadow: 0px 0px 3px 1px orangered;" value="https://twitter.com/user">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" id="facebook" name="facebook" class="form-control" value="<?php echo $row['facebook']; ?>" style=" box-shadow: 0px 0px 3px 1px orangered;" value="https://www.facebook.com/user">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" id="linkedin" name="linkedin" class="form-control" value="<?php echo $row['linkedin']; ?>" style=" box-shadow: 0px 0px 3px 1px orangered;" value>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" id="instagram" name="instagram" class="form-control" value="<?php echo $row['instagram']; ?>" style=" box-shadow: 0px 0px 3px 1px orangered;" value="https://www.instagram.com/user">
                                </div>
                            </div>
                        </div>
                        
                            
                            
                        
                    </div>
                </div>
            </div>
                                    
        </div>
        <div class="text-right mt-3">
        <button type="submit" id="saveChangesButton" class="btn btn-primary" style="border: 2px solid #fc3b00; background-color: orangered;">Save changes</button>

            <button type="button" class="btn btn-default" style="box-shadow: 0px 0px 6px 1px orangered; border: 2px solid #fc3b00;">Cancel</button>
        </div>
    </div>
                                    </form>
                                 
    <script>
        

    // Add an event listener to the save changes button
    document.getElementById("saveChangesButton").addEventListener("click", function() {
        // Check if the new password and repeat password match
        var newPassword = document.getElementById("newPassword").value;
        var repeatPassword = document.getElementById("repeatPassword").value;

        if (newPassword !== repeatPassword) {
            // Display an error message if passwords do not match
            document.getElementById("passwordError").style.display = "block";
            return; // Exit the function if passwords do not match
        }

        // If passwords match, proceed with form submission or any other action
        // You can add your form submission logic here
        // For example, you can submit the form using JavaScript's submit() method
        // document.getElementById("yourFormId").submit();
    });
</script>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
    <script>
    // Assume you have fetched the profile data in a variable named 'profileData'
    var profileData = <?php echo json_encode($profileData); ?>;

    // Populate the form fields with the fetched data
    document.getElementById("firstName").value = profileData.firstName;
    document.getElementById("lastName").value = profileData.lastName;
    document.getElementById("email").value = profileData.email;
    // Similarly, populate other form fields with the respective data
</script>










</body>
</html>
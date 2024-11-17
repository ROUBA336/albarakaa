<?php 
   session_start();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        function validateForm() {
            var email = document.forms["registrationasso"]["email"].value;
            var password = document.forms["registrationasso"]["password"].value;

            // Check email format
            if (!email.endsWith("@gmail.com")) {
                alert("Email must end with '@gmail.com'");
                return false;
            }

            // Check password criteria (modify as needed)
            if (password.length < 8) {
                alert("Password must be at least 8 characters long");
                return false;
            }
            // You can add more criteria for password validation here (e.g., requiring special characters, numbers, etc.)

            // If all validation passes, return true to submit the form
            return true;
        }
    </script>
    </head>


    <body>
        <div class="wrapper" style="overflow:hidden;height:470px;">
          <span class="bg-animate"  style="position: absolute;
            top:0px;
            right: 0;
            width: 850px;
            height: 600px;
            border-bottom:3px solid red ;
            background: linear-gradient(45deg, #11213b,red);
            transform: rotate(10deg) skewY(40deg);
            transform-origin: bottom right;
            transition: 1.5s ease;"></span>
          <span class="bg-animate2"></span>
          <div class="form-box login" style="height:700px;" >
    
          <?php 
         
         include("db_conn.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
        
            $password = $_POST['password'];

         //verifying the unique email

         $verify_query = mysqli_query($conn,"SELECT username FROM signupevent WHERE username='$username'");
         if (mysqli_num_rows($verify_query) != 0) {
          echo "<script>alert('This username is already in use. Please choose another one.');</script>";
          // You can add further actions here if needed
      } else {
          // Insert the user's data into the database
          $result = mysqli_query($conn, "INSERT INTO signupevent (username, email, password) VALUES ('$username', '$email', '$password')");
          if ($result) {
              // Registration successful, redirect to home page
              $_SESSION['username'] = $username; // Set session variable
              header("Location: homeevent.php");
              exit();
          } else {
              echo "Error: " . mysqli_error($conn); // Handle database error if needed
          }
      }

         }else{
         
        ?>
              <h2 class="animation" style="--i:0;margin-top:-240px;margin-left:-30px;">Sign Up</h2>
              <form method="POST"  action="" >
                <div class="input-box animation" style="--i:1;">
                  <input type="text" name="username" required>
                  <label>Username</label>
                  <i class='bx bx-user'></i>
                </div>

                <div class="input-box animation" style="--i:1;">
                  <input type="text" name="email" required>
                  <label>Email</label>
                  <i class='bx bx-envelope'></i>
                </div>

                <div class="input-box animation" style="--i:2;">
                  <input type="password" name="password" required>
                  <label>password</label>
                  <i class='bx bx-lock'></i>
                </div>
                <div class="input-box animation" style="--i:2;">
                  <input type="password" name="password" required>
                  <label>Confirm password</label>
                  <i class='bx bx-lock'></i>
                </div>

                <button type="submit" name="submit" class="btn" style="--i:21;">Sign Up</button>

                <div class="logreg-link animation" style="margin-top:10px;">
                  <p>Already have an account <a href="events.php" class="" style="--i:4;">Log In</a></p>
                </div>


              </form>
          </div>
          <div class="info-text login" >
            <h2 class="animation" style="--i:0;">Welcome Back!</h2>
            <p class="animation" style="--i:1;">Please sign up adding your personal information to stay connected with us.</p>
          </div>
          <?php } ?>
        </div>

        <script src="script.js"></script>
    </body>
    </html>
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
        <div class="wrapper" style="overflow:hidden;">
        
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
          <div class="form-box login">
    
          <?php 
         
         include("db_conn.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
        
            $password = $_POST['password'];

         //verifying the unique email

         $verify_query = mysqli_query($conn,"SELECT username FROM signupvolun WHERE username='$username'");

         if(mysqli_num_rows($verify_query) !=0 ){
            echo "<div class='message'>
                      <p>This username is used, Try another One Please!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         else{

            mysqli_query($conn,"INSERT INTO signupvolun(username,email,password) VALUES('$username','$email','$password')") or die("Erroe Occured");

            echo "<div class='message'>
            <p>Registration successful!</p>
          </div> <br>";
   
    // Redirect to home page after successful registration
    header("Location: volunteer.php");
    exit();

         

         }

         }else{
         
        ?>
              <h2 class="animation" style="--i:0;">Sign Up</h2>
              <form method="POST"  action=""  >
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

                <button type="submit" name="submit" id="submit"  class="btn" style="--i:21;">Sign Up</button>

                <div class="logreg-link animation">
                  <p>Already have an account <a href="loginvolunteer.php" class="" style="--i:4;">Log In</a></p>
                </div>


              </form>
          </div>
          <div class="info-text login">
            <h2 class="animation" style="--i:0;">Welcome Back!</h2>
            <p class="animation" style="--i:1;">Please log in using your personal information to stay connected with us.</p>
          </div>
          <?php } ?>
        </div>

        <script src="script.js"></script>
    </body>
    </html>
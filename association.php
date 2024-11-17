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
</head>
<body>
    <div class="wrapper" style="overflow:hidden;">
        <span class="bg-animate" style="position: absolute;
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

          // Check if form is submitted
          if(isset($_POST['submit'])){
              // Escape user inputs to prevent SQL injection
              $username = mysqli_real_escape_string($conn, $_POST['username']);
              $password = mysqli_real_escape_string($conn, $_POST['password']);
      
              // Query the database for user credentials
              $result = mysqli_query($conn, "SELECT * FROM signupasso WHERE username='$username' AND password='$password' ") or die("Query Error: " . mysqli_error($conn));
              $row = mysqli_fetch_assoc($result);
      
              // Check if user exists
              if(is_array($row) && !empty($row)){
                  $_SESSION['username'] = $row['username'];
                  header("Location: homeasso.php");
                  exit();
              } else {
                  // Display error message for incorrect credentials
                  echo "<div class='message'>
                      <p>Wrong Username or Password</p>
                      </div> <br>";
                  echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
              }
        
      
        }else{
         
             ?>
            <h2 class="animation" style="--i:0;">login</h2>
            <form method="POST" action="">
                <div class="input-box animation" style="--i:1;">
                    <input type="text" name="username" required>
                    <label>Username</label>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box animation" style="--i:2;">
                    <input type="password" name="password" required>
                    <label>Password</label>
                    <i class='bx bx-lock'></i>
                </div>
                <button type="submit" name="submit" class="btn" style="--i:21;">Log In</button>
                <div class="logreg-link animation">
                    <p>Don't have an account <a href="associationsign.php" class="" style="--i:4;">Sign Up</a></p>
                </div>
            </form>
        </div>
        <div class="info-text login">
            <h2 class="animation" style="--i:0;">Welcome Back!</h2>
            <p class="animation" style="--i:1;">Please log in using your personal information to stay connected with us.</p>
        </div>
        <?php }?>
    </div>
    <script src="script.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation bar design usign html & css & javascript</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet"href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <div class="bg-img">
    <header class="header-area">
        <div class="header-container">
            
            <div class="site-logo">
                <a href="#">AL<span>BARAKA</span></a>
            </div>
            <div class="mobile-nav">
                <i class="fas fa-bars"></i>
            </div>
            <div class="site-nav-menu">
                <ul class="primary-menu">
                    <li><a href="#" class="active">Home</a></li>
                    <li><a href="#fwmanage">What We DO</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                 
                    <li><a href="#">login</a>
                        <ul class="dropdown" >

                            <li><a href="adminprofile.php">Admin</a></li>
                            <li><a href="events.php">Events</a></li>
                            <li><a href="loginvolunteer.php">Volunteer</a></li>
                            <li><a href="association.php">Associations</a></li>
                        </ul>

                      </li>
                      <li><a href="#">sign up</a>
                        <ul class="dropdown" >

                            
                            <li><a href="eventsignup.php">Events</a></li>
                            <li><a href="volunteersignup.php">Volunteer</a></li>
                            <li><a href="associationsign.php">Associations</a></li>
                        </ul>

                      </li>
                </ul>
                <div class="menu-toggle"></div>
            </div>
        </div>
      
    </header>
    <div class="title">
        <h1>AL BARAKA </h1>
        <br><br>
        <p>“If you’re throwing away food, you’re throwing away life.” </p>
  
    </div>
   </div>
    

    <section class="fwmanage" id="fwmanage">
    <div class="fwm-title" >
        <h2>What is food waste management system?</h2>
    </div>

    <div class="container-box">
        
        <h4>The Food Waste Management System is designed for the amount of food waste produced
             by businesses,restaurants,bakery,events... It contains meal management tools and campaigns to help 
             distribute excess breakfast leftover food in restaurants and wedding halls. 
             The point is that food can feed people instead of ending up in a landfill. 
             An example of this is that if  the wedding is large,than the party becomes more bigger,thisthe leads to wasting 
             larger amounts of food. 
             There is no doubt that weddings and banquets constitute a huge source of food waste.
             Nearly 50% of food is lost <br> <br>
             Here,<b>AL<span>BARAKA</span></b>comes into the picture. We have come up with an initiative to reduce 
             food waste and hunger as much as possible with the aim of eliminating hunger and responsible consumption and production. 
             We are in contact with some banquets and restaurants who cooperate with us to inform us of a time to collect 
             the surplus food. We collect food supplies through volunteers, whether by packing or distributing them 
             to people who need them. <br> <br></br></br>
        <center><iframe width="620" height="400" src="https://www.youtube.com/embed/N_NqljUe4Ws?si=TA9zBuNEODlRkMxM"
             title="YouTube video player" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
               allowfullscreen></iframe>
        </center>
        </h4>

    </div>
</section>


     <!-- Footer -->

     <section class="footer">
        <div class="foot">
            <div class="footer-content">
                
                <div class="footlinks">
                    <h4 style="left: 10px;">Quick Links</h4>
                    <ul >
                        <li><a href="events.php">Add Event</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                </div>
    
                <div class="footlinks">
                    <h4 style="left: 60px;">Connect</h4>
                    <div class="social">
                        <a href="" target="_blank"><i class='bx bxl-facebook'></i></a>
                        <a href="" target="_blank"><i class='bx bxl-instagram' ></i></a>
                        <a href="" target="_blank"><i class='bx bxl-twitter' ></i></a>
                        
                        <a href="" target="_blank"><i class='bx bxl-youtube' ></i></a>
                       
                    </div>
                </div>
                
            </div>
        </div>
    
        <div class="end">
            <p>Tel:81/254271 Email: support@albaraka.com | Copyright © 2024 AlBaraka | All Rights Reserved. <br>Website developed by: Rouba Mohammad Ayach| Dr. Rami Safarjalani| </p>
        </div>
    </section>
    
    <section id="hero-section"></section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="app.js"></script>

    <script>
        function redirectToPage() {
            var selectedUser = document.getElementById("userDropdown").value;
            if (selectedUser === "user1") {
                window.location.href = "user1.html"; // Replace with the actual page for User 1
            } else if (selectedUser === "user2") {
                window.location.href = "user2.html"; // Replace with the actual page for User 2
            }
            // Add more conditions for additional users/pages as needed
        }

      
    </script>
    <script>

function redirectToAdminProfile() {
           
            window.location.href = "adminprofile.php";
        }
        </script>
</body>
</html>

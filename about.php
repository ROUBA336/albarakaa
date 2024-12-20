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
<body class="aboutbody">
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
                    <li><a href="index.php" >Home</a></li>
                    <li><a href="./index.php#fwmanage">What We DO</a></li>
                    <li><a href="about.php" class="active">About</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
                <div class="menu-toggle"></div>
            </div>
        </div>
      
    </header>
        
    <section class="about">
           <div class="main">


           
      
 
       
       

       <div class="image" >
             <img class="mySlides" src="img1.jpg" >
             <img class="mySlides" src="img2.jpg" >
             <img class="mySlides" src="img3.jpg" >
             <img class="mySlides" src="img4.jpg" >
             <img class="mySlides" src="img5.jpg" >
             <img class="mySlides" src="img6.jpg" >
        </div>

            <div class="abt-text">
                <h1>About <span>Us</span></h1>
                <p>AL<span style="color: orangered;">BARAKA</span> is a food waste management system designed to reduce the food wastage 
                    and use it in a useful way.</br> This system also provide a platform to people where 
                    they can tell our about the time to bring surplus food.</br>We are in contact with restaurants bakery and other events
                    in order to distribute food among associations,orphanage and the people who really need it. 
                    It does not only reduce food 
                    waste but also hunger, which is a major problem of the world. We believe nutritious food 
                    should go to people, not landfills. This website is developed by: <br>
                     ->Dr. Rami Safarjalani  <br>->Rouba Mohamad Ayach</p></br>
                <a href="contact.html" class="connectbtn" target="_blank">Connect with us!</a>

                <div class="connect-section">

                    <div class="social-icons">
                        <a href="" target="_blank"><i class='bx bxl-facebook'></i></a>
                        <a href="" target="_blank"><i class='bx bxl-instagram' ></i></a>
                        <a href="" target="_blank"><i class='bx bxl-twitter' ></i></a>
                        
                        <a href="" target="_blank"><i class='bx bxl-youtube' ></i></a>
                    
                    </div>

                </div>
            </div>
            

           </div>
           
        
    </section>


    <!-- Footer -->

<!-- Footer -->

<section class="footer">
    <div class="foot">
        <div class="footer-content">
            
            <div class="footlinks">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="events.php">Add Event</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>

            <div class="footlinks">
                <h4>Connect</h4>
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




<script>
    var myIndex = 0;
    carousel();
    
    function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
      }
      myIndex++;
      if (myIndex > x.length) {myIndex = 1}    
      x[myIndex-1].style.display = "block";  
      setTimeout(carousel, 3000); // Change image every 2 seconds
    }
    </script>


<section id="hero-section"></section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="app.js"></script>

</body>
</html>
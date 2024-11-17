$(document).ready(function(){
    $(".mobile-nav i").click(function(){
        $(".site-nav-menu").toggleClass("mobile-menu");
    });
 });

 let slideIndex = 1;
 showSlides(slideIndex);
 
 // Next/previous controls
 function plusSlides(n) {
   showSlides(slideIndex += n);
 }
 
 // Thumbnail image controls
 function currentSlide(n) {
   showSlides(slideIndex = n);
 }
 
 
<?php
session_start();
require_once('navbar.php');
if (!isset($_SESSION['email'])) {
    header('location:login.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <link rel="stylesheet" href="stye eco.css" />
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <title>GamingPlanet</title>
        <style>
           
            .swiper-slide img {
                width: 100%;
                height: 100vh;
               
                height: auto;
               
                display: block;
               
                margin: 0 auto;
               
            }

           
            .swiper-container {
                display: flex;
               
                justify-content: center;
               
                align-items: center;
               
            }
        </style>
    </head>

    <body>



        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="photo/Sl1.jpg" alt="Image 1"></div>
                <div class="swiper-slide"><img src="photo/Sl4.jpg" alt="Image 2"></div>

            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>


        <script>
            var swiper = new Swiper(".swiper-container", {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                autoplay: {
                    delay: 5000, 
                    disableOnInteraction: false, 
                },
                speed: 1000, 
            });



            var scrollToTopBtn = document.getElementById("scroll-up");
            var rootElement = document.documentElement;

            function scrollToTop() {
                
                rootElement.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            }
            scrollToTopBtn.addEventListener("click", scrollToTop);


            var scrollToTopBtn = document.getElementById("scroll-up");
            var rootElement = document.documentElement;

            function scrollToTop() {
                
                rootElement.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            }
            scrollToTopBtn.addEventListener("click", scrollToTop);
        </script>


        <?php
        require_once('footer.php');
        ?>
    </body>


    </html>

<?php
}
?>
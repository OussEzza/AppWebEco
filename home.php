<?php
session_start();
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
        <link rel="icon" href="photo/7553408.jpg" type="image/x-icon">
        <title>Accueil - GamingPlanet</title>
        <style>
            img{
                width: 1600px;
             
            }
        </style>

    </head>

    <body>
        <?php require_once('navbar.php'); ?>


        <video autoplay muted loop>
            <source src="photo/White Shadows Razer Chroma Announcement Trailer.mp4" type="video/mp4">
         </video>
         <img src="photo/img2.jpeg" alt=" ">
  
        <div class="container-div">
            <div class="content">
                <h1 class="bien">Bienvenue chez GamingPlanet !</h1>
                <p class="bien">Découvrez notre collection de produits</p>
                <a href="produit1.php" class="shop-button"><button id="btn">Aller à la boutique</button></a>
            </div>
        </div>

        <div>
            <?php require_once('footer.php'); ?>
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


    </body>


    </html>

<?php
}
?>
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
        <title>ShoppingPlanet</title>
        <style>
            /* Styles pour les images dans le slider */
            .swiper-slide img {
                width: 100%;
                height: 100vh;
                /* Ajuste la largeur des images au conteneur du slider */
                height: auto;
                /* Garantit une hauteur proportionnelle pour les images */
                display: block;
                /* Permet de centrer les images horizontalement */
                margin: 0 auto;
                /* Centre les images dans le conteneur */
            }

            /* Centrage du slider */
            .swiper-container {
                display: flex;
                /* Utilise un conteneur flexible pour aligner le slider */
                justify-content: center;
                /* Centre le contenu horizontalement */
                align-items: center;
                /* Centre le contenu verticalement */
            }
        </style>
    </head>

    <body>


        <!-- Structure HTML pour le Slider d'Images -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="photo/Sl1.jpg" alt="Image 1"></div>
                <div class="swiper-slide"><img src="photo/Sl4.jpg" alt="Image 2"></div>
                <!-- <div class="swiper-slide"><img src="photo/Sl3.jpg" alt="Image 3"></div> -->
                <!-- Ajoutez autant de diapositives que nécessaire -->
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>


        <script>
            var scrollToTopBtn = document.getElementById("scroll-up");
            var rootElement = document.documentElement;

            function scrollToTop() {
                // Scroll to top logic
                rootElement.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            }
            scrollToTopBtn.addEventListener("click", scrollToTop);


            var scrollToTopBtn = document.getElementById("scroll-up");
            var rootElement = document.documentElement;

            function scrollToTop() {
                // Scroll to top logic
                rootElement.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            }
            scrollToTopBtn.addEventListener("click", scrollToTop);
        </script>


<?php
require_once ('footer.php');
?>
    </body>

    
    </html>

<?php
}
?>
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
            img {
                /* position: absolute; */
                width: 100%;
            }

            .container-div {
                font-size: 22px;
                margin: 0;
                margin-bottom: -60px;
                padding: 0;
                font-family: Arial, sans-serif;
                
            }

            video {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: -1;
                display: block;
            }


            .content {
                padding: 20px;
                text-align: center;
                color: #fff;
                z-index: 1;
            }

            .bien {
                color: #0dff00;
            }

            .shop-button {
                text-decoration: none;
                color: black;
            }

            #btn {
                /* position: absolute; */
                border: none;
                border-radius: 8px;
                /* bottom: 100px; */
                padding: 10px;
                font-size: 14px;
                font-weight: 600;
                background-color: #0dff00;
                /* margin-right: 50px; */
                /* flex: wrap; */
            }

            #btn:hover {
                background-color: #15b300;
                cursor: pointer;
            }

            #logo-planet{
                color: #0dff00;
            }
        </style>

    </head>

    <body>
        <?php require_once('navbar.php'); ?>

        <div>
            <img src="photo/Sl3.jpg" alt=" ">
        </div>
        <div>
            <video autoplay muted loop>
                <source src="photo/White Shadows Razer Chroma Announcement Trailer.mp4" type="video/mp4">
            </video>
        </div>
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
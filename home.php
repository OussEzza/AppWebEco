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
                <div class="swiper-slide"><img src="photo/Sl2.jpg" alt="Image 2"></div>
                <!-- <div class="swiper-slide"><img src="photo/K3.jpg" alt="Image 3"></div> -->
                <!-- Ajoutez autant de diapositives que nécessaire -->
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>






        <button id="scroll-up"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5" />
            </svg></button>

        <?php

        require_once('connection.php');
        $currentUserId = $_SESSION['id']; // Exemple d'ID utilisateur - à adapter

        $query = "SELECT SUM(quantity) AS total_items FROM panier WHERE user_id = '$currentUserId'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalItems = $row['total_items']; // Nombre total d'articles dans le panier
        } else {
            $totalItems = 0;
        }
        ?>



        <footer id="footer" class="bg-accent padding-xlarge">
            <p class="description">La boutique GamingPlanet est un lieu où des experts de l’informatique et du high-tech conseillent et orientent les clients marocains. C’est également un espace où nous créons des machines sur-mesure et réparent des produits. GamingPlanet est la première boutique gaming qui offre des produits sous Licence officielle provenant des plus grandes marques de gaming au monde. Cela, afin de garantir une qualité exceptionnelle, des produits authentiques sous garantie fabricant et des prix imbattables.</p>
            <hr>
            <div class="container">
                <div class="row">

                    <div class="col-md-3 footer-intro">
                        <div class="footer-menu">
                            <h4 class="footer-logo"><b>GamingPlanet</b></h4>
                            <br>
                            <p>NEWSLETTER</p>
                            <div class="form-content">
                                <form>
                                    <input type="text" name="email" placeholder="enter your email address">
                                    <button class="btn btn-black">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="footer-menu">
                            <h5>Liens rapides</h5>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="profil.php">Profil</a>
                                </li>
                                <li class="menu-item">
                                    <a href="home.php">Acceuil</a>
                                </li>
                                <li class="menu-item">
                                    <a href="produit1.php">Produits</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">À propos</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="footer-menu">
                            <h5>Nos catégorie</h5>
                            <ul>
                                <li><a href="produit1.php#section1">Claviers</a></li>
                                <li><a href="produit1.php#section2">Écouteurs</a></li>
                                <li><a href="produit1.php#section3">Souris</a></li>
                                <li><a href="produit1.php#section4">Tapis de souris</a></li>
                            </ul>
                            <ul>
                                <li><a href="produit1.php#section5">Accessoires streaming</a></li>
                                <li><a href="produit1.php#section6">PlayStation</a></li>
                                <li><a href="produit1.php#section7">Jeux</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="footer-menu">
                            <h5>Liens rapides</h5>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="profil.php">Profil</a>
                                </li>
                                <li class="menu-item">
                                    <a href="home.php">Acceuil</a>
                                </li>
                                <li class="menu-item">
                                    <a href="produit1.php">Produits</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">À propos</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="footer-menu">
                            <h5>Iinformations de contact</h5>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>
                                    +212 607 080 910
                                </li>
                                <li class="menu-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>
                                    +212 509 080 706
                                </li>
                                <li class="menu-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                    </svg>
                                    SIDI BENNOUR, Maroc
                                </li>
                                <li class="menu-item">
                                    <a href="mailto:ezzahrioussama01@gmail.com"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                        </svg></a> <span class="mail">ezzahrioussama01@gmail.com</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="social-links">
                    <p>Liens sociaux :</p>
                    <ul>
                        <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                </svg></a></li>
                        <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                                </svg></a></li>
                        <li><a href="mailto:ezzahrioussama01@gmail.com"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg></a></li>
                        <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                    <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408z" />
                                </svg></a></li>
                    </ul>
                </div>


                <div id="footer-bottom" class="bg-accent padding-medium">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12 footer-links">
                                <div class="copyright">
                                    <p>© 2023 GamingPlanet.</p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </footer>


        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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
                    delay: 3000, // Délai entre chaque slide en millisecondes (par exemple 5000 pour 5 secondes)
                    disableOnInteraction: false, // Pour continuer l'autoplay après une interaction de l'utilisateur
                },
                speed: 1000, // Réglez la vitesse de défilement à 1 seconde (1000 millisecondes)
            });

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


    </body>

    </html>

<?php
}
?>
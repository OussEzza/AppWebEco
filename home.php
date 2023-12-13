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
        <link rel="stylesheet" href="stye eco.css" />
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <title>ShoppingPlanet</title>
        <style>
            .slideshow {
                max-width: 100%;
                position: relative;
                margin: auto;
            }

            .slides {
                display: none;
                position: absolute;
                width: 100%;
                height: auto;
            }
        </style>
    </head>

    <body>

        <!-- <div class="slideshow">
            <img class="slides" src="photo/G1.jpg" alt="Image 1">
            <img class="slides" src="photo/G2.jpg" alt="Image 2">
        </div> -->



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


        <footer>
            <div class="footer-navigation">
                <ul>
                    <li><a href="home.php">Accueil</a></li>
                    <li><a href="produit1.php">Produits</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/faq">FAQ</a></li>
                </ul>
            </div>

            <div class="newsletter">
                <h3>Inscription à la newsletter</h3>
                <form action="votre-script-d-inscription-newsletter.php" method="post">
                    <input type="email" name="email" placeholder="Entrez votre e-mail" required>
                    <button type="submit">S'abonner</button>
                </form>
            </div>

            <div class="contact-info">
                <h3>Coordonnées</h3>
                <p>Email: contact@votreentreprise.com</p>
                <p>Téléphone: +XX XXX XXX XXX</p>
                <p>Adresse: 123 Rue Principale, Ville, Pays</p>
            </div>

            <div class="social-media">
                <h3>Suivez-nous</h3>
                <ul>
                    <li><a href="lien-vers-facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="lien-vers-twitter"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="lien-vers-instagram"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>

            <div class="legal">
                <ul>
                    <li><a href="/politique-de-confidentialite">Politique de confidentialité</a></li>
                    <li><a href="/conditions-d-utilisation">Conditions d'utilisation</a></li>
                    <li><a href="/politique-de-retour">Politique de retour</a></li>
                </ul>
            </div>

            <div class="payment-options">
                <h3>Paiement sécurisé</h3>
                <p>Nous acceptons : Visa, Mastercard, PayPal</p>
            </div>

            <div class="customer-support">
                <h3>Assistance client</h3>
                <p><a href="/assistance">Besoin d'aide? Contactez-nous!</a></p>
            </div>

            <div class="gift-cards">
                <h3>Cartes-cadeaux</h3>
                <p>Offrez du shopping avec nos cartes-cadeaux!</p>
            </div>

            <div class="about-us">
                <h3>À propos de nous</h3>
                <p>Une brève description de votre entreprise et de sa mission.</p>
            </div>

            <div class="security-badge">
                <!-- Ajoutez ici des images ou des badges de sécurité -->
                <img src="votre-badge-securite.png" alt="Badge de sécurité">
            </div>
        </footer>


        <!-- <script>
            let slideIndex = 0;
            carousel();

            function carousel() {
                let i;
                const slides = document.getElementsByClassName("slides");
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                slideIndex++;
                if (slideIndex > slides.length) {
                    slideIndex = 1;
                }
                slides[slideIndex - 1].style.display = "block";
                setTimeout(carousel, 3000); // Change d'image toutes les 3 secondes (3000 millisecondes)
            }


            // JavaScript ici pour utiliser le résultat PHP, par exemple :
            var itemCount = <?php //echo $totalItems; ?>;
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('nombreProduitsPanier').innerText = itemCount;
            });
        </script> -->

    </body>

    </html>

<?php
    echo $_SESSION['id'];
}
?>
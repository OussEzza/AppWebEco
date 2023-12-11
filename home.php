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
        <link rel="stylesheet" href="stye eco.css" />
        <link rel="stylesheet" href="product.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <title>ShoppingPlanet</title>
    </head>

    <body>
        <header>
            <div class="category-logo">
                <a href="profil.php"><i class="fas fa-user"></i></a>
            </div>
            <div class="logo">
                <h1><a href="home.php">ShoppingPlanet</a></h1>
            </div>
            <div class="search-box">
                <form>
                    <input type="search" id="search" name="search" placeholder="Rechercher des produits" />
                    <button id="submitsearch" type="submit" class="button" name="search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="home.php"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li>
                        <a href="produit1.php"><i class="fas fa-shopping-bag"></i> Produits</a>
                        <ul class="submenu">
                            <li><a href="produit1.php#section1">Claviers</a></li>
                            <li><a href="produit1.php#section2">Écouteurs</a></li>
                            <li><a href="produit1.php#section3">Souris</a></li>
                            <!-- Ajoutez autant d'options que nécessaire -->
                        </ul>
                    </li>
                    <li>
                        <a href="panier.php"><i class="fas fa-shopping-cart"></i> Mon Panier</a>
                        <span id="nombreProduitsPanier" class="cart-item-count"></span>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-info-circle"></i> À Propos</a>
                    </li>
                    <li>
                        <a href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                    </li>
                    <div class="compte">
                        <a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg></i></a>
                    </div>
                </ul>
            </nav>
        </header>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>



        <?php

        // obtenir_nombre_produits_panier.php
        require_once ('connection.php');
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

        <a href="mail.php">go to send mail</a>

        <script>
            // JavaScript ici pour utiliser le résultat PHP, par exemple :
            var itemCount = <?php echo $totalItems; ?>;
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('nombreProduitsPanier').innerText = itemCount;
            });
        </script>

    </body>

    </html>

<?php
    echo $_SESSION['id'];
}
?>
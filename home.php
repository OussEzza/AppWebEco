<?php
session_start();
if (!isset($_SESSION['username'])) {
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
                <a href="#"><i class="fas fa-user"></i></a>
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
                            <li><a href="#section1">Claviers</a></li>
                            <li><a href="#section2">Écouteurs</a></li>
                            <li><a href="#section3">Souris</a></li>
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
                        <a><i class="fas fa-user"></i></a>
                    </div>
                </ul>
            </nav>
        </header>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>




        <a href="mail.php">go to send mail</a>
    </body>

    </html>

<?php
echo $_SESSION['id'];
}
?>
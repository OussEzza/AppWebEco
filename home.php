<body>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="stye eco.css" />
        <link rel="stylesheet" href="product.css">
        <!-- <link rel="stylesheet" href="style.css"> -->
        <!-- <link rel="stylesheet" href="stylespanier.css"> -->
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



        <?php
        require_once('connection.php');
        session_start(); // Démarrer la session si ce n'est pas déjà fait

        $currentUserId = 1; // Exemple d'ID utilisateur - à adapter

        // Utilisation de la variable $currentUserId dans la requête pour filtrer par ID d'utilisateur
        $query = "SELECT * FROM users";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $rowUser = mysqli_fetch_assoc($result);

            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $rowUser['Id'];
            // ... Ajoutez d'autres données d'utilisateur si nécessaire dans la session
        } else {
            // Gérer les erreurs ou afficher un message approprié si la requête échoue
            echo "Erreur lors de la récupération des informations de l'utilisateur.";
        }
        ?>














    </body>

    </html>
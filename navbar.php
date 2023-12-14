<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="stye eco.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>GamingPlanet</title>
</head>

<body>
    <header>
        <div class="compte">
            <a href="profil.php"><i class="fas fa-user"></i></a>
        </div>
        <div class="logo">
            <h1 style="margin-right: 700px;"><a href="home.php">GamingPlanet</a></h1>
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
                        <li><a href="produit1.php#section4">Tapis de souris</a></li>
                        <li><a href="produit1.php#section5">Accessoires streaming</a></li>
                        <li><a href="produit1.php#section6">PlayStation</a></li>
                        <li><a href="produit1.php#section7">Jeux</a></li>
                    </ul>
                </li>
                <li>
                    <a href="panier.php"><i class="fas fa-shopping-cart"></i> Mon Panier</a>
                    <span id="nombreProduitsPanier" class="cart-item-count"></span>
                </li>
                <li>
                    <a href="contact.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-text-fill" viewBox="0 0 16 16">
                            <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z" />
                        </svg> Contact</a>
                </li>

                <li>
                    <div class="compte">
                        <a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg></i></a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>



    <?php

    require_once('connection.php');
    $currentUserId = $_SESSION['id']; 

    $query = "SELECT SUM(quantity) AS total_items FROM panier WHERE user_id = '$currentUserId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $totalItems = $row['total_items']; 
    } else {
        $totalItems = 0;
    }
    ?>

    <script>
        var itemCount = <?php echo $totalItems; ?>;
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nombreProduitsPanier').innerText = itemCount;
        });
    </script>
</body>

</html>
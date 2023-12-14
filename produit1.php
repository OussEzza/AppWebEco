<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
} else {
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="stye eco.css">
        <link rel="stylesheet" href="product.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link rel="icon" href="photo/7553408.jpg" type="image/x-icon">
        <title>Produits - GamingPlanet</title>
    </head>

    <body>
        <header>
            <div class="compte">
                <a href="profil.php"><i class="fas fa-user"></i></a>
            </div>
            <div class="logo">
                <h1><a href="home.php">GamingPlanet</a></h1>
            </div>
            <div class="search-box">
                <form id="searchForm" method="GET" action="produit1.php">
                    <input type="search" id="searchInput" name="search" placeholder="Rechercher des produits" />
                    <button type="submit" class="button" name="search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
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

        $error = "";
        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];

            $query = "SELECT * FROM products WHERE product_name LIKE '%$searchTerm%'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product-details">';
                    echo '<div class="image-container">';
                    echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                    echo '</div>';
                    echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                    echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                    echo '<p>Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                    echo '<div class="button-container">';
                    echo '<form method="post" class="inline-form">';
                    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                    echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                    echo '</form>';
                    echo '<button class="affdetails"><a class="stretched-link" href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun produit trouvé.</p>';
            }
        }
        ?>
        <section id="section1" class="section">
            <h2 class="h2section">Claviers</h2>
            <div class="product-grid">
                <?php
                $query = "SELECT * FROM products WHERE categories = 'Keyboards'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="product-details">';
                        echo '<div class="image-container">';
                        echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                        echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                        echo '<p>Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                        echo '<div class="button-container">';
                        echo '<form method="post" class="inline-form">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                        echo '</form>';
                        echo '<button class="affdetails"><a class="stretched-link" href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </section>


        <section id="section2" class="section">
            <h2 class="h2section">Écouteurs</h2>
            <div class="product-grid">
                <?php

                $query = "SELECT * FROM products WHERE categories = 'headphones'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="product-details">';
                        echo '<div class="image-container">';
                        echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                        echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                        echo '<p>Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                        echo '<div class="button-container">';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                        echo '</form>';
                        echo '<button class="affdetails"><a href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>        ';
                        echo '</div>';
                        echo '</div>';
                    }
                }

                ?>
            </div>
        </section>


        <section id="section3" class="section">
            <h2 class="h2section">Souris</h2>
            <div class="product-grid">
                <?php

                $query = "SELECT * FROM products WHERE categories = 'mouses'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="product-details">';
                        echo '<div class="image-container">';
                        echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                        echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                        echo '<p id="errorMessage" class="quantity">Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                        echo '<div class="button-container">';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                        echo '</form>';
                        echo '<button class="affdetails"><a href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>        ';
                        echo '</div>';
                        echo '</div>';
                    }
                }

                ?>
            </div>
        </section>


        <section id="section4" class="section">
            <h2 class="h2section">Tapis de souris</h2>
            <div class="product-grid">
                <?php

                $query = "SELECT * FROM products WHERE categories = 'tapis'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="product-details">';
                        echo '<div class="image-container">';
                        echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                        echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                        echo '<p id="errorMessage" class="quantity">Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                        echo '<div class="button-container">';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                        echo '</form>';
                        echo '<button class="affdetails"><a href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>        ';
                        echo '</div>';
                        echo '</div>';
                    }
                }

                ?>
            </div>
        </section>


        <section id="section5" class="section">
            <h2 class="h2section">Accessoires Streaming</h2>
            <div class="product-grid">
                <?php

                $query = "SELECT * FROM products WHERE categories = 'streaming'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="product-details">';
                        echo '<div class="image-container">';
                        echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                        echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                        echo '<p id="errorMessage" class="quantity">Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                        echo '<div class="button-container">';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                        echo '</form>';
                        echo '<button class="affdetails"><a href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>        ';
                        echo '</div>';
                        echo '</div>';
                    }
                }

                ?>
            </div>
        </section>


        <section id="section6" class="section">
            <h2 class="h2section">PlayStation</h2>
            <div class="product-grid">
                <?php

                $query = "SELECT * FROM products WHERE categories = 'console'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="product-details">';
                        echo '<div class="image-container">';
                        echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                        echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                        echo '<p id="errorMessage" class="quantity">Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                        echo '<div class="button-container">';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                        echo '</form>';
                        echo '<button class="affdetails"><a href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>        ';
                        echo '</div>';
                        echo '</div>';
                    }
                }

                ?>
            </div>
        </section>


        <section id="section7" class="section">
            <h2 class="h2section">Jeux</h2>
            <div class="product-grid">
                <?php

                $query = "SELECT * FROM products WHERE categories = 'games'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="product-details">';
                        echo '<div class="image-container">';
                        echo '<img class="product-image" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<h4>' . htmlspecialchars($row['product_name']) . '</h4>';
                        echo '<p class="price">Prix: ' . htmlspecialchars($row['price']) . ' MAD</p>';
                        echo '<p id="errorMessage" class="quantity">Quantité: ' . htmlspecialchars($row['quantitate']) . '</p>';
                        echo '<div class="button-container">';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                        echo '</form>';
                        echo '<button class="affdetails"><a href="details.php?id=' . $row['id'] . '">Voir les détails</a></button>        ';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </section>

        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
            $currentUserId = $_SESSION['id'];
            $productId = $_POST['product_id'];

            $query = "SELECT * FROM panier WHERE product_id = '$productId' AND user_id = '$currentUserId'";
            $result = mysqli_query($conn, $query);

            $queryQuantity = "SELECT SUM(quantity) AS total_quantity FROM panier WHERE product_id = '$productId' ";
            $resultQuantity = mysqli_query($conn, $queryQuantity);
            $rowQuantity = mysqli_fetch_assoc($resultQuantity);
            $quantityTotal = $rowQuantity['total_quantity'];



            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $quantity = $row['quantity'];

                $queryProduct = "SELECT quantitate FROM products WHERE id = '$productId'";
                $resultProduct = mysqli_query($conn, $queryProduct);

                if ($resultProduct && mysqli_num_rows($resultProduct) > 0) {
                    $rowProduct = mysqli_fetch_assoc($resultProduct);
                    $availableQuantity = $rowProduct['quantitate'];

                    if ($quantityTotal < $availableQuantity) {
                        $newQuantity = $quantity + 1;
                        $updateQuery = "UPDATE panier SET quantity = '$newQuantity' WHERE product_id = '$productId' AND user_id = '$currentUserId'";
                        $updateResult = mysqli_query($conn, $updateQuery);
                    } else {
                        echo '<script>';
                        echo 'document.addEventListener(\'DOMContentLoaded\', function() {';
                        echo '    var button = document.querySelector(\'.addpanier[data-product-id="' . $productId . '"]\');';
                        echo '    button.style.color = \'black\';';
                        echo '    button.style.backgroundColor = \'red\';';
                        echo '    button.style.padding = \'6px\';';
                        echo '    button.innerText = \'En rupture de stock\';';
                        echo '    button.disabled = true;';
                        echo '});';
                        echo '</script>';

                        echo '<div id="errorMessage" class="error-message">Maximum quantity !!</div>';
                        echo '<script>
                    setTimeout(function(){
                        document.getElementById("errorMessage").style.display = "none";
                    }, 3000); // Disparaît après 3 secondes (3000 ms)
                    </script>';
                    }
                }
            } else {
                $currentUserId = $_SESSION['id'];
                $productId = $_POST['product_id'];
                $selectedQuantity = 1; // La quantité par défaut
                $insertQuery = "INSERT INTO panier (user_id, product_id, quantity) VALUES ('$currentUserId', '$productId', '$selectedQuantity')";
                $insertResult = mysqli_query($conn, $insertQuery);
            }
        }


        if (!empty($error) || !empty($error1)) {
            echo '<div class="error-message">' . ($error ? $error : $error1) . '</div>';
            echo '<script>
            setTimeout(function(){
                document.querySelector(".error-message").style.display = "none";
            }, 3000); // Disparaît après 3 secondes (3000 ms)
            </script>';
        }



        $currentUserId = $_SESSION['id'];

        $query = "SELECT SUM(quantity) AS total_items FROM panier WHERE user_id = '$currentUserId'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalItems = $row['total_items'];
        } else {
            $totalItems = 0;
        }

        require_once('footer.php');


        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchForm = document.querySelector('form[action="produit1.php"]');
                const productDetails = document.querySelectorAll('.product-details');

                searchForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const searchTerm = document.querySelector('input[name="search"]').value.trim().toLowerCase();

                    productDetails.forEach(function(product) {
                        const productName = product.querySelector('h4').innerText.trim().toLowerCase();
                        const displayStyle = productName.includes(searchTerm) ? 'block' : 'none';
                        product.style.display = displayStyle;
                    });
                });
            });



            var itemCount = <?php echo $totalItems; ?>;
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('nombreProduitsPanier').innerText = itemCount;
            });


            document.addEventListener('', function() {
                const addpanierbtn = document.getElementsByClassName('addpanier');
                addpanierbtn.style.display = inline - block;
            });
        </script>

    </body>

    </html>

<?php
}
?>
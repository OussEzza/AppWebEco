<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stylespanier.css">
        <title>Panier</title>
    </head>

    <body>
        <?php
        session_start();
        require_once('connection.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Suppression d'un produit du panier
            if (isset($_POST['remove_btn'])) {
                $productId = $_POST['remove_product'];
                $currentUserId = $_SESSION['id']; // Exemple d'ID utilisateur - à adapter

                $query = "DELETE FROM panier WHERE user_id = $currentUserId AND product_id = $productId";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    header("Location: panier.php");
                    exit();
                }
            }

            // Modification de la quantité d'un produit dans le panier
            // ... Update quantité (+)

            // Traitement pour l'incrémentation de la quantité
            $error = "";
            if (isset($_POST['new_quantity_plus'])) {
                $productId = $_POST['update_quantity'];
                $currentUserId1 = $_SESSION['id'];
                // Récupérer la quantité actuelle du produit dans le panier
                $currentQuantityQuery = "SELECT SUM(quantity) AS total_quantity FROM panier WHERE product_id = $productId";
                $currentQuantityResult = mysqli_query($conn, $currentQuantityQuery);
                $currentQuantityRow = mysqli_fetch_assoc($currentQuantityResult);
                $currentQuantity = $currentQuantityRow['total_quantity']; // Utiliser le nom de l'alias défini dans la requête SQL


                // Récupérer la quantité disponible dans le stock pour ce produit
                $availableQuantityQuery = "SELECT quantitate FROM products WHERE id = $productId";
                $availableQuantityResult = mysqli_query($conn, $availableQuantityQuery);
                $availableQuantityRow = mysqli_fetch_assoc($availableQuantityResult);
                $availableQuantity = $availableQuantityRow['quantitate'];

                // Vérifier si la quantité totale ne dépasse pas la quantité disponible
                if ($currentQuantity < $availableQuantity) {
                    // Mettre à jour la quantité dans le panier en ajoutant 1
                    $updateQuery = "UPDATE panier SET quantity = quantity + 1 WHERE product_id = $productId and user_id = $currentUserId1";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if ($updateResult) {
                        header("Location: panier.php");
                        exit();
                    }
                } else {
                    $error = "Quantité non disponible en stock.";
                }
            }

            // Traitement pour la décrémentation de la quantité
            $error1 = "";
            if (isset($_POST['new_quantity_less'])) {
                $productId = $_POST['update_quantity'];
                $currentUserId2 = $_SESSION['id'];

                // Récupérer la quantité actuelle du produit dans le panier
                $currentQuantityQuery = "SELECT quantity AS total_quantity FROM panier WHERE product_id = $productId and user_id = $currentUserId2";
                $currentQuantityResult = mysqli_query($conn, $currentQuantityQuery);
                $currentQuantityRow = mysqli_fetch_assoc($currentQuantityResult);
                $currentQuantity = $currentQuantityRow['total_quantity']; // Utiliser le nom de l'alias défini dans la requête SQL


                // Vérifier si la quantité dans le panier est supérieure à zéro
                if ($currentQuantity > 1) {
                    // Mettre à jour la quantité dans le panier en soustrayant 1
                    $updateQuery = "UPDATE panier SET quantity = quantity - 1 WHERE product_id = $productId and user_id = $currentUserId2";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if ($updateResult) {
                        header("Location: panier.php");
                        exit();
                    }
                } else {
                    $error1 = "La quantité actuelle dans le panier est déjà de un (il est le minumun).";
                }
            }
        }
        // Affichage du message d'erreur si une erreur est survenue

        if (!empty($error) || !empty($error1)) {
            echo '<div class="error-message">' . ($error ? $error : $error1) . '</div>';
            echo '<script>
            setTimeout(function(){
                document.querySelector(".error-message").style.display = "none";
            }, 3000); // Disparaît après 3 secondes (3000 ms)
          </script>';
        }


        // Récupération des produits dans le panier pour l'utilisateur actuel
        $currentUserId = $_SESSION['id'];
        $query = "SELECT products.id, products.product_name, products.price, products.product_image, panier.quantity
          FROM products
          JOIN panier ON products.id = panier.product_id
          WHERE panier.user_id = '$currentUserId'";

        $result = mysqli_query($conn, $query); // Placez cette ligne après la définition de $query


        $totalAmount = 0;

        if ($result && mysqli_num_rows($result) > 0) {
            // Affichage des détails des produits dans le panier
            echo '<table class="table1">';
            echo '<tr>';
            echo '<th>Numéro du produit</th>';
            echo '<th>Photo</th>';
            echo '<th>Nom</th>';
            echo '<th>Quantité</th>';
            echo '<th>Prix</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            $productNumber = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $productNumber . '</td>';
                echo '<td><img class="imgpanier" src="' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" /></td>';
                echo '<td>' . $row['product_name'] . '</td>';

                echo '<td>';
                echo '<form method="post" action="panier.php">';
                echo '<input type="hidden" name="update_quantity" value="' . $row['id'] . '">';
                echo '<button class="quantiteless" type="submit" name="new_quantity_less">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
            </svg>';
                echo '</button>';
                echo '<span class="spanquantity">' . $row['quantity'] . '</span>';
                echo '<button class="quantiteplus" type="submit" name="new_quantity_plus">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>';
                echo '</button>';
                echo '</form>';
                echo '</td>';


                echo '<td>' . $row['price'] * $row['quantity'] . ' $</td>';
                echo '<td>';
                echo '<form method="post" action="panier.php">';
                echo '<input type="hidden" name="remove_product" value="' . $row['id'] . '">';
                echo '<input class="btnremove" type="submit" name="remove_btn" value="X">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';

                $productNumber++;
                $totalAmount += $row['price'] * $row['quantity'];
            }
            echo '</table>';

            echo '<div class ="total-panier">';
            echo '<h1>Total panier</h1>';
            echo '<table class="total-panier-table">';
            echo '<tr>';
            echo '<th>SOUS-TOTAL</th>';
            echo '<td><h5 class="sous-total" >' . $totalAmount . ' MAD</h5> </td>';
            echo '</tr>';

            echo '<tr>';
            echo '<th>EXPÉDITION</th>';
            echo '<td><h5 class="expedition" > Livraison gratuite par tout au maroc !</h5></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<th>TOTAL PANIER</th>';
            echo '<td><h5 class="sous-total" >' . $totalAmount . ' MAD</h5></td>';
            echo '</tr>';


            echo '</table>';
            echo '<button class="gopayment" ><a href="payment.php">Valider la commande</a></button>';
            echo '</div>';
        } else {
            echo '<div class="Noproduct">';
            echo '<img src="https://ae01.alicdn.com/kf/Sa15be314eadd4a9bb186ab4a0cb971b5D/360x360.png_.webp" class="es--comet-pro-fallback-image--35CZGig" data-spm-anchor-id="a2g0o.cart.0.i3.3244378d1lo9Se"/>';
            echo '<p class="no-product-message">Pas encore d\'articles ? Continuez vos achats pour en savoir plus.</p>';
            echo '</div>';
        }
        echo '<button class="btnback"><a href="produit1.php">Retour aux produits</a></button>';




        ?>
    </body>

    </html>

<?php
}
?>
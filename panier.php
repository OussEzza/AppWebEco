<?php
session_start();
require_once('navbar.php');
if (!isset($_SESSION['email'])) {
    header('location:login.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stylespanier.css">
        <link rel="icon" href="photo/7553408.jpg" type="image/x-icon">
        <title>Panier - GamingPlanet</title>
    </head>

    <body>
        <?php
        require_once('connection.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['remove_btn'])) {
                $productId = $_POST['remove_product'];
                $currentUserId = $_SESSION['id']; 

                $query = "DELETE FROM panier WHERE user_id = $currentUserId AND product_id = $productId";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    header("Location: panier.php");
                    exit();
                }
            }



            $error = "";
            if (isset($_POST['new_quantity_plus'])) {
                $productId = $_POST['update_quantity'];
                $currentUserId1 = $_SESSION['id'];
                $currentQuantityQuery = "SELECT SUM(quantity) AS total_quantity FROM panier WHERE product_id = $productId";
                $currentQuantityResult = mysqli_query($conn, $currentQuantityQuery);
                $currentQuantityRow = mysqli_fetch_assoc($currentQuantityResult);
                $currentQuantity = $currentQuantityRow['total_quantity']; 


                $availableQuantityQuery = "SELECT quantitate FROM products WHERE id = $productId";
                $availableQuantityResult = mysqli_query($conn, $availableQuantityQuery);
                $availableQuantityRow = mysqli_fetch_assoc($availableQuantityResult);
                $availableQuantity = $availableQuantityRow['quantitate'];

                if ($currentQuantity < $availableQuantity) {
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

            $error1 = "";
            if (isset($_POST['new_quantity_less'])) {
                $productId = $_POST['update_quantity'];
                $currentUserId2 = $_SESSION['id'];

                $currentQuantityQuery = "SELECT quantity AS total_quantity FROM panier WHERE product_id = $productId and user_id = $currentUserId2";
                $currentQuantityResult = mysqli_query($conn, $currentQuantityQuery);
                $currentQuantityRow = mysqli_fetch_assoc($currentQuantityResult);
                $currentQuantity = $currentQuantityRow['total_quantity']; 



                if ($currentQuantity > 1) {
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

        if (!empty($error) || !empty($error1)) {
            echo '<div class="error-message">' . ($error ? $error : $error1) . '</div>';
            echo '<script>
            setTimeout(function(){
                document.querySelector(".error-message").style.display = "none";
            }, 3000); // Disparaît après 3 secondes (3000 ms)
            </script>';
        }


        $currentUserId = $_SESSION['id'];
        $query = "SELECT products.id, products.product_name, products.price, products.product_image, panier.quantity
          FROM products
          JOIN panier ON products.id = panier.product_id
          WHERE panier.user_id = '$currentUserId'";

        $result = mysqli_query($conn, $query); 

        $totalAmount = 0;

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<div class="table-conrtainer">';
            echo '<table class="table1">';
            echo '<tr>';
            echo '<th>Photo</th>';
            echo '<th>Nom</th>';
            echo '<th class="rowQuantity">Quantité</th>';
            echo '<th class="rowQuantity">Prix</th>';
            echo '<th>Action</th>';
            echo '</tr>';


            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td style="text-align: center;"><img class="imgpanier" src="photo/' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" /></td>';
                echo '<td>' . $row['product_name'] . '</td>';

                echo '<td class="rowQuantity">';
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


                echo '<td class="rowQuantity">' . $row['price'] * $row['quantity'] . ' MAD</td>';
                echo '<td>';
                echo '<form method="post" action="panier.php">';
                echo '<input type="hidden" name="remove_product" value="' . $row['id'] . '">';
                echo '<button class="btnremove" type="submit" name="remove_btn" value="X">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>';
                echo '</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';


                $totalAmount += $row['price'] * $row['quantity'];
            }
            echo '</table>';
            echo '</div>';
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
            echo '<img src="photo/NoProduct.webp" class="es--comet-pro-fallback-image--35CZGig" data-spm-anchor-id="a2g0o.cart.0.i3.3244378d1lo9Se"/>';
            echo '<p class="no-product-message">Pas encore d\'articles ? Continuez vos achats pour en savoir plus.</p>';
            echo '</div>';
        }
        echo '<button class="btnback"><a href="produit1.php">Retour aux produits</a></button>';



      
        require_once ('footer.php');
        
        ?>
    </body>

    </html>

<?php
}
?>
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
        <link rel="icon" href="photo/7553408.jpg" type="image/x-icon">
        <title>Détails du Produit - GamingPlanet</title>
        <link rel="stylesheet" href="styledetails.css">
    </head>

    <body>

        <?php

        require_once('connection.php');

        
        
        
        if (isset($_GET['id'])) {
            $productID = $_GET['id'];

            $sql = "SELECT * FROM products WHERE id = $productID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                echo '<div class = "image-description"';
                echo '<span class="image-container">';
                echo '<a href="photo/' . $row['product_image'] . '" target="_blank""><img id="product-image" src="photo/' . $row['product_image'] . '" alt="' . $row['product_name'] . '" /></a>';
                echo '</span>';
                echo '<div class="description-container">';
                echo '<h4>Description: </h4> <p class="description">' . $row['description'] . '</p>';
                echo '<h4>Caractéristiques :</h4> <pre class="description">' . $row['Caracteristiques'] . '</pre>';
                echo '</div>';
                echo '</div>';
                echo '<div class="info-container">';
                echo '<h3>' . $row['product_name'] . '</h3>';
                echo '<p class="price">Prix : ' . $row['price'] . ' MAD</p>';
                echo '<p class="quantity">Quantité en stock : ' . $row['quantitate'] . '</p>';
                echo '</div>';
                echo '<form method="post">';
                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                echo '<button class="addpanier" id="add-to-cart" type="submit" name="add_to_cart" data-product-id="' . $row['id'] . '">Ajouter au Panier</button>';
                echo '</form>';
                echo '<div class="image-buttons">';
                echo '<a href="produit1.php"><button class="btnback" >Back To Product</button></a>';
                echo '</div>';
            } else {
                echo "Aucun produit trouvé pour cet ID.";
            }
        } else {
            echo "Aucun ID de produit fourni.";
        }
        
        
            
        $TotalQuantityQuery = "SELECT SUM(quantity) as totalQuantity FROM panier WHERE product_id = '$productID'";
        $result = mysqli_query($conn, $TotalQuantityQuery);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalQuantityEnPanier = !empty($row['totalQuantity']) ? $row['totalQuantity'] : 0;


            $QuantityLimitQuery = "SELECT quantitate FROM products WHERE id = '$productID'";
            $result = mysqli_query($conn, $QuantityLimitQuery);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $quantityLimit = !empty($row['quantitate']) ? $row['quantitate'] : 0;


                if ($totalQuantityEnPanier >= $quantityLimit) {

                    echo '<script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var addButton = document.getElementById("add-to-cart");
                            addButton.disabled = true;
                            addButton.style.backgroundColor = "rgb(231, 67, 67)";
                            addButton.innerHTML = "En rupture de stock";
                        });
                        </script>';
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
            $currentUserId = $_SESSION['id']; // Exemple d'ID utilisateur - à adapter
            $productId = $_POST['product_id'];

            // Vérifier si le produit existe déjà dans le panier de l'utilisateur actuel
            $query = "SELECT * FROM panier WHERE product_id = '$productId' AND user_id = '$currentUserId'";
            $result = mysqli_query($conn, $query);

            $queryQuantity = "SELECT SUM(quantity) AS total_quantity FROM panier WHERE product_id = '$productId' ";
            $resultQuantity = mysqli_query($conn, $queryQuantity);
            $rowQuantity = mysqli_fetch_assoc($resultQuantity);
            $quantityTotal = $rowQuantity['total_quantity']; // Récupérer la quantité actuelle du produit dans le panier



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
                        echo '    button.style.color = \'red\';';
                        echo '    button.innerText  = \'Maximum quantity\';';
                        echo '    button.disabled = true;'; 
                        echo '    button.style.cursor = not-allowed;';
                        echo '});';
                        echo '</script>';
                    }
                } 
            } else {
                $currentUserId = $_SESSION['id'];
                $productId = $_POST['product_id'];
                $selectedQuantity = 1; 
                $insertQuery = "INSERT INTO panier (user_id, product_id, quantity) VALUES ('$currentUserId', '$productId', '$selectedQuantity')";
                $insertResult = mysqli_query($conn, $insertQuery);
            }
        }

        ?>

    </body>

    </html>


<?php
}
?>
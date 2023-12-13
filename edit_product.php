<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = $_POST['price'];
    $quantitate = $_POST['quantitate'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $update_query = "UPDATE products SET
        product_name = '$product_name',
        price = '$price',
        quantitate = '$quantitate',
        description = '$description',
        categories = '$category'
        WHERE id = '$product_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo '   <p>Produit mis à jour avec succès!</p>';
    } else {
        echo '<p>Erreur lors de la mise à jour du produit : ' . mysqli_error($conn) . '</p>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier le Produit</title>
            <style>
                body {
                    font-family: "Arial", sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }

                h1 {
                    text-align: center;
                    color: #333;
                }

                form {
                    max-width: 400px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                label {
                    display: block;
                    margin-bottom: 8px;
                    color: #555;
                }

                input {
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 15px;
                    box-sizing: border-box;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }

                input[type="submit"] {
                    background-color: #555;
                    color: #fff;
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background-color: green;
                }

                p {
                    color: #e74c3c;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
        
            <h1>Modifier le Produit</h1>';
        
        // Affiche le formulaire pré-rempli avec les détails du produit
        echo '<form action="" method="post" enctype="multipart/form-data">';
        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
        
        echo '<label for="product_name">Nom du Produit:</label>';
        echo '<input type="text" name="product_name" value="' . htmlspecialchars($row['product_name']) . '" required>';
        echo '<br>';
        
        echo '<label for="price">Prix:</label>';
        echo '<input type="number" min="0" name="price" value="' . $row['price'] . '" required>';
        echo '<br>';
        
        echo '<label for="quantitate">Quantité:</label>';
        echo '<input type="number" min="0" name="quantitate" value="' . $row['quantitate'] . '" required>';
        echo '<br>';
        
        echo '<label for="description">Description:</label>';
        echo '<textarea name="description" required>' . htmlspecialchars($row['description']) . '</textarea>';
        echo '<br>';
        
        echo '<label for="category">Catégorie:</label>';
        echo '<input type="text" name="category" value="' . htmlspecialchars($row['categories']) . '" required>';
        echo '<br>';
        
        echo '<input type="submit" value="Enregistrer les modifications" name="update_product">';
        echo '</form>';
        
        echo '</body>
        </html>';
    } else {
        echo '<p>Produit non trouvé.</p>';
    }
} 
?>

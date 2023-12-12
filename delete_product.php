<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);

    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Supprimer le Produit</title>
        <style>
            body {
                font-family: "Arial", sans-serif;
                background-color: #f4f4f4;
                color: #333;
                margin: 0;
                padding: 0;
                text-align: center;
            }

            h1 {
                color: #333;
            }

            p {
                color: #e74c3c;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
    
        <h1>Supprimer le Produit</h1>';
    
    if ($result) {
        echo '<p>Produit supprimé avec succès.</p>';
    } else {
        echo '<p>Erreur lors de la suppression du produit : ' . mysqli_error($conn) . '</p>';
    }
    
    echo '</body>
    </html>';
} else {
    echo '<p>Mauvaise requête.</p>';
}
?>

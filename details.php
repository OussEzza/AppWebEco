<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <link rel="stylesheet" href="styledetails.css">
</head>

<body>

    <?php

    // Informations de connexion à la base de données
    $servername = "localhost"; // Nom du serveur MySQL
    $username = "root"; // Votre nom d'utilisateur MySQL
    $password = ""; // Votre mot de passe MySQL
    $dbname = "storeos"; // Nom de votre base de données

    // Créer une connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Vérifie si l'ID du produit est présent dans l'URL
    if (isset($_GET['id'])) {
        // Récupère l'ID du produit depuis l'URL
        $productID = $_GET['id'];

        // Exécute la requête SQL pour récupérer les détails du produit en fonction de l'ID
        $sql = "SELECT * FROM products WHERE id = $productID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Affiche les détails du produit
            $row = $result->fetch_assoc();

           
            echo '<div class = "image-description"';

            echo '<span class="image-container">';
            echo '<img id="product-image" src="' . $row['product_image'] . '" alt="' . $row['product_name'] . '" />';
            echo '</span>';
            echo '<div>';
            echo '<h4>Description: </h4> <pre class="description">' . $row['description'] . '</pre>';
            echo'</div>';
            echo '</div>';

            echo '<div class="info-container">';
            echo '<h2>' . $row['product_name'] . '</h2>';
            echo '<p class="price">Prix: ' . $row['price'] . '</p>';
            echo '<p class="quantity">Quantité: ' . $row['quantitate'] . '</p>';
            echo '</div>';
            echo '<div class="image-buttons">';
            echo '<button class="btnback" ><a href="produit1.php">Back To Product</a></button>';
            echo '</div>';
        } else {
            echo "Aucun produit trouvé pour cet ID.";
        }
    } else {
        echo "Aucun ID de produit fourni.";
    }
    ?>
    
</body>

</html>
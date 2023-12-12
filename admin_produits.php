<!-- manage_products.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            padding: 30px;
            height: 20px;
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
       
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #555;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    img.product-image {
        max-width: 100px;
        max-height: 100px;
        border-radius: 5px;
    }

    .action-links {
        display: flex;
        justify-content: space-between;
    }

    .action-links a {
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 3px;
        color: #fff;
        cursor: pointer;
    }

    .edit-link {
        background-color: #3498db;
    }

    .edit-link:hover {
        background-color: #2980b9;
    }

    .delete-link {
        background-color: #e74c3c;
    }

    .delete-link:hover {
        background-color: #c0392b;
    }
    
    
    
    
</style>
    </style>
</head>
<link rel="stylesheet" href="admin_page.css">
<header class="header">
    <div class="flex">
        <a href="<?php echo $_SESSION['type'] === 'admin' ? 'admin_page.php' : 'home.php'; ?>" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="admin_page.php">Accueil</a>
            <a href="admin_produits.php">Produits</a>
            <a href="admin_orders.php">Commandes</a>
            <a href="admin_users.php">Utilisateurs</a>
            <a href="admin_contacts.php">Messages</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
    </div>
</header>
<body>

    <h1>Gestion des Produits</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="product_name">Nom du Produit:</label>
        <input type="text" name="product_name" required>
        <br>

        <label for="price">Prix:</label>
        <input type="number" min="0" name="price" required>
        <br>

        <label for="quantitate">Quantité:</label>
        <input type="number" min="0" name="quantitate" required>
        <br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>

        <label for="product_image">Image du Produit:</label>
        <input type="file" name="product_image" accept="image/jpg, image/jpeg, image/png" required>
        <br>

        <div class="mb-3">
            <label for="category">Catégorie:</label>
            <input type="text" name="category" required>
        </div>
        

        <input type="submit" value="Ajouter le Produit" name="add_product">
    </form>

    <?php
    // Inclure le fichier de connexion à la base de données
    require_once('connection.php');

    // Gérer les actions (Ajout, Modification, Suppression)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_product'])) {
            $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
            $price = $_POST['price'];
            $quantitate = $_POST['quantitate'];
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);

            $target_dir = "photo/";
            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Vérifier si le fichier existe déjà
            if (file_exists($target_file)) {
                echo "Désolé, le fichier existe déjà.";
                $uploadOk = 0;
            }

            // Vérifier la taille du fichier
            if ($_FILES["product_image"]["size"] > 500000) {
                echo "Désolé, votre fichier est trop volumineux.";
                $uploadOk = 0;
            }

            // Vérifier si le fichier est une image
            $check = getimagesize($_FILES["product_image"]["tmp_name"]);
            if ($check === false) {
                echo "Le fichier n'est pas une image.";
                $uploadOk = 0;
            }

            // Vérifier les types de fichiers autorisés
            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            if (!in_array($imageFileType, $allowedTypes)) {
                echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                $uploadOk = 0;
            }

            // Si tout est OK, télécharger le fichier
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    echo "Le fichier " . htmlspecialchars(basename($_FILES["product_image"]["name"])) . " a été téléchargé.";

                    $insert_query = "INSERT INTO products (product_name, price, quantitate, description, product_image, categories) VALUES ('$product_name', '$price', '$quantitate', '$description', '" . basename($_FILES["product_image"]["name"]) . "', '$category')";
                    $insert_result = mysqli_query($conn, $insert_query);

                    if ($insert_result) {
                        echo '<p>Produit ajouté avec succès!</p>';
                    } else {
                        echo '<p>Erreur lors de l\'ajout du produit : ' . mysqli_error($conn) . '</p>';
                    }
                } else {
                    echo "Une erreur s'est produite lors du téléchargement de votre fichier.";
                }
            } else {
                echo "Désolé, votre fichier n'a pas été téléchargé.";
            }
        } elseif (isset($_POST['update_product'])) {
            // Traitement de la mise à jour de produit
            // ...
        }
    }

    // Afficher les produits depuis la base de données
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nom du Produit</th><th>Prix</th><th>Quantité</th><th>Description</th><th>Image</th><th>Catégorie</th><th>Actions</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['product_name'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td>' . $row['quantitate'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td><img src="photo/' . $row['product_image'] . '" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>';
            echo '<td>' . $row['categories'] . '</td>';
            echo '<td>';
            echo '<a href="edit_product.php?id=' . $row['id'] . '">Modifier</a> | ';
            echo '<a href="delete_product.php?id=' . $row['id'] . '" onclick="return confirm(\'Voulez-vous vraiment supprimer ce produit?\')">Supprimer</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Erreur lors de la récupération des produits : ' . mysqli_error($conn) . '</p>';
    }
    ?>

</body>
</html>

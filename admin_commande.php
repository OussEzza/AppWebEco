<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="Admin0.css">
    <title>Commandes</title>
    <link rel="stylesheet" href="admin_page.css">
</head>

<body>
    <header class="header">
        <div class="flex">
            <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>
            <nav class="navbar">
                <a href="admin_page.php">Accueil</a>
                <a href="admin_produits.php">Produits</a>
                <a href="admin_commande.php">Commandes</a>
                <a href="admin_users.php">Utilisateurs</a>
                <a href="admin_contacts.php">Messages</a>
            </nav>
            <button class="mobile-menu-button">&#9776;</button>
        </div>
    </header>

    <?php
    // Assurez-vous que le fichier de connexion est inclus correctement
    include('connection.php');

    // Vérifiez si la connexion à la base de données est établie
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Orders
    $selectQuery = "SELECT * FROM orders";
    $result = mysqli_query($conn, $selectQuery);
    ?>

    <section class="orders">

        <div class="box-container">

            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                    <div class="box">
                        <p> user id : <span><?php echo $fetch_orders['id']; ?></span> </p>
                        <p> placed on : <span><?php echo $fetch_orders['address']; ?></span> </p>
                        <p> name : <span><?php echo $fetch_orders['username']; ?></span> </p>
                        <p>Payment Method: <span><?php echo $fetch_orders['method_payment']; ?></span></p>
                        <p>Total Price: <span><?php echo $fetch_orders['total_price']; ?>$</span></p>
                        <p>livraison Status: <span style="color:<?php echo ($fetch_orders['livraison_status'] == 'En route vers la livraison') ? 'red' : 'green'; ?>"><?php echo $fetch_orders['livraison_status']; ?></span></p>

                        <?php
                        // Vérifiez si l'utilisateur actuel est un administrateur
                        $isAdmin = true; // Mettez votre propre logique pour vérifier le statut d'administrateur ici

                        if ($isAdmin) {
                        ?>
                            <!-- Formulaire de modification du statut de livraison -->
                            <form action="admin_commande.php" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                            <label for="new_status">Statut :</label>
                            <select name="new_status" id="new_status">
                                <option value="En attente" <?php echo ($fetch_orders['livraison_status'] == 'En attente') ? 'selected' : ''; ?>>En attente</option>
                                <option value="En cours" <?php echo ($fetch_orders['livraison_status'] == 'En cours') ? 'selected' : ''; ?>>En cours</option>
                                <option value="Terminé" <?php echo ($fetch_orders['livraison_status'] == 'Terminé') ? 'selected' : ''; ?>>Terminé</option>
                            </select>
                            <button type="submit" name="Update_order">Modifier</button>
                        </form>
                        <?php
                        }
                        ?>

                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no orders placed yet!</p>';
            }
            ?>
        </div>
    </section>

    <script src="script.js"></script>
</body>

</html>

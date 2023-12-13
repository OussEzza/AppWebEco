<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="Admin0.css">
    <title>Orders</title>
</head>

<body>
<link rel="stylesheet" href="admin_page.css">
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
    </header>

    <?php
    // Assurez-vous que le fichier de connexion est inclus correctement
    include('connection.php');

    // Vérifiez si la connexion à la base de données est établie
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Orders
    $selectQuery = "SELECT * FROM orders";
    $result = mysqli_query($con, $selectQuery);
    ?>

    <div class="container">
        <?php
        // delete order
        if (isset($_POST['Delete_order'])) {
            $id = $_POST['order_id'];
            $DeleteQuery = "DELETE FROM orders WHERE id ='$id'";
            mysqli_query($con, $DeleteQuery);
            header('location: Admin_orders.php');
        }

        if (isset($_POST['Update_order'])) {
            $orderId = $_POST['order_id'];
            $newStatus = $_POST['new_status'];

            $Query = "UPDATE orders SET payment_status = '$newStatus' WHERE id = $orderId";
            mysqli_query($con, $Query);
            header('location: Admin_commande.php');
        }
        ?>
    </div>

    <section class="orders">
        <h1 class="title">Placed Orders</h1>
        <div class="box-container">
            <?php
            $select_orders = mysqli_query($con, "SELECT * FROM orders") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                    <div class="box">
                        <p> user id : <span><?php echo $fetch_orders['id']; ?></span> </p>
                        <p> placed on : <span><?php echo $fetch_orders['address']; ?></span> </p>
                        <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                        <!-- ... (le reste du code) ... -->
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

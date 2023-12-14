<?php
// Assurez-vous que le fichier de connexion est inclus correctement
include('connection.php');

// Vérifiez si la connexion à la base de données 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Traitement du formulaire de mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Update_order'])) {
    $orderId = $_POST['order_id'];
    $newLivraisonStatus = $_POST['new_status'];

     
    $selectOldStatus = mysqli_query($conn, "SELECT livraison_status FROM orders WHERE id = '$orderId'");
    
    
    if ($selectOldStatus) {
        $oldStatusArray = mysqli_fetch_assoc($selectOldStatus);
        $oldLivraisonStatus = $oldStatusArray['livraison_status'];

         
        $updateQueryOrders = "UPDATE orders SET livraison_status = '$newLivraisonStatus' WHERE id = '$orderId'";
        mysqli_query($conn, $updateQueryOrders);

         
        $updateQueryHistorique = "UPDATE historique SET etat_commande = '$newLivraisonStatus' WHERE commande_id = '$orderId'";
        mysqli_query($conn, $updateQueryHistorique);

         
        header('location: Admin_commande.php');
    } else {
        echo "Erreur lors de la récupération de l'ancien statut.";
    }
}
?>   



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="Admin0.css">
    <title>Commandes</title>
    <link rel="stylesheet" href="admin_page.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            
            margin: 0;
            padding: 0;
           
        }

         
        .mobile-menu-button {
            display: none;
        }

        .orders {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px;
        }

        .box-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .box {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .box:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            background-color: white;
        }
         
        tr:hover {
            background-color: #ddd;
        }

        form {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 5px;
        }

        select {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        button.red {
            background-color: #e74c3c;
        }

        button.red:hover {
            background-color: #c0392b;
        }

        .empty {
            text-align: center;
            margin: 20px;
            color: #555;
        }

       
        
    </style>
</head>

<body>
    <header class="header">
        <div class="flex">
            <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>
            <nav class="navbar" id="myNavbar">
                <a href="admin_page.php">Accueil</a>
                <a href="admin_produits.php">Produits</a>
                <a href="admin_commande.php">Commandes</a>
                <a href="admin_users.php">Utilisateurs</a>
                <a href="admin_contact.php">Messages</a>
                <a class="mobile-menu-button" href="javascript:void(0);" onclick="toggleNavbar()">&#9776;</a>
            </nav>
        </div>
    </header>

    <section class="orders">
        <div class="box-container">
            <?php
            require_once('connection.php');
            $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
            ?>
                <table>
                    <tr>
                        <th>User ID</th>
                        <th>Placed On</th>
                        <th>Name</th>
                        <th>Payment Method</th>
                        <th>Total Price</th>
                        <th>Livraison Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                    ?>
                        <tr>
                            <td><?php echo $fetch_orders['id']; ?></td>
                            <td><?php echo $fetch_orders['address']; ?></td>
                            <td><?php echo $fetch_orders['username']; ?></td>
                            <td><?php echo $fetch_orders['method_payment']; ?></td>
                            <td><?php echo $fetch_orders['total_price']; ?>$</td>
                            <td style="color:<?php echo ($fetch_orders['livraison_status'] == 'E----*n cours') ? 'red' : 'green'; ?>"><?php echo $fetch_orders['livraison_status']; ?></td>
                            <td>
                                <?php
                                $isAdmin = true; // Mettez votre propre logique pour vérifier le statut d'administrateur ici
                                if ($isAdmin) {
                                ?>
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
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            } else {
                echo '<p class="empty">No orders placed yet!</p>';
            }
            ?>
        </div>
    </section>

    <script>
        function toggleNavbar() {
            var x = document.getElementById("myNavbar");
            if (x.className === "navbar") {
                x.className += " responsive";
            } else {
                x.className = "navbar";
            }
        }
    </script>
</body>

</html>

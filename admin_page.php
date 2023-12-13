<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panneau d’administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="admin_page.css">
    <style>
        /* Exemple de styles dans admin_page.css */
        body {
            font-family: 'Arial', sans-serif;
        }

        .DASHBOARD {
            padding: 20px;
        }

        .title {
            color: #333;
            text-align: center;
        }

        .box-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .box {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .box h3 {
            color: #333;
        }

        .box p {
            color: #777;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animated-box {
            animation: fadeIn 1s ease-in-out;
        }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>
    <?php
    include('connection.php'); // Assurez-vous que le chemin est correct
    ?>
    <section class="DASHBOARD">

        <h1 class="title">TABLEAU DE BORD</h1>

        <div class="box-container">

            <div class="box animated-box">
                <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                $number_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h3><?php echo $number_of_orders; ?></h3>
                <p>Total des commandes</p>
            </div>

            <div class="box animated-box">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                $number_of_products = mysqli_num_rows($select_products);
                ?>
                <h3><?php echo $number_of_products; ?></h3>
                <p>Produits ajoutés</p>
            </div>

            <div class="box animated-box">
                <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE type = 'user'") or die('query failed');
                $number_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?php echo $number_of_users; ?></h3>
                <p>Normale Utilisateurs</p>
            </div>

            <div class="box animated-box">
                <?php
                $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE type = 'admin'") or die('query failed');
                $number_of_admins = mysqli_num_rows($select_admins);
                ?>
                <h3><?php echo $number_of_admins; ?></h3>
                <p>Utilisateurs Admin</p>
            </div>

            <div class="box animated-box">
                <?php
                $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                $number_of_account = mysqli_num_rows($select_account);
                ?>
                <h3><?php echo $number_of_account; ?></h3>
                <p>Totals des comptes</p>
            </div>

            <div class="box animated-box">
                <?php
                $total_completed = 0;
                $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders`  ") or die('query failed');
                if (mysqli_num_rows($select_completed) > 0) {
                    while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
                        $total_price = $fetch_completed['total_price'];
                        $total_completed += $total_price;
                    };
                };
                ?>
                <h3><?php echo $total_completed; ?>$</h3>
                <p>Paiements effectués</p>
            </div>

            <div class="box animated-box">
                <canvas id="orderChart"></canvas>
            </div>

        </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin_script.js"></script>

    <script>
        var orderChart = new Chart(document.getElementById('orderChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Label1', 'Label2', 'Label3'],
                datasets: [{
                    label: 'Orders',
                    data: [/* Your data here */],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

</body>

</html>

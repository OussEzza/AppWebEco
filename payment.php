<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stylepayment.css">
        <title>Payment</title>
    </head>

    <body>
        <div class="container">
            <div class="column left">

                <?php
                session_start();
                require_once('connection.php');

                // Code pour envoyer un e-mail de confirmation avec un code de vérification
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
                    // Génération d'un code de vérification aléatoire (Vous pouvez ajuster la longueur du code)
                    $verificationCode = substr(md5(uniqid(mt_rand(), true)), 0, 8);

                    // Récupération des données de l'utilisateur (remplacez par votre méthode)
                    $currentUserId = $_SESSION['id'];
                    $queryUserInfo = "SELECT * FROM users WHERE id = $currentUserId";
                    $resultUserInfo = mysqli_query($conn, $queryUserInfo);
                    $userInfo = mysqli_fetch_assoc($resultUserInfo);

                    // Envoi de l'e-mail de confirmation avec le code de vérification
                    // $to = $userInfo['email']; // Adresse e-mail de l'utilisateur
                    $to = "ezzahriraja@gmail.com";
                    $subject = 'Confirmation de votre achat';
                    $message = 'Bonjour ' . $userInfo['name'] . ',<br><br>';
                    $message .= 'Merci pour votre achat.<br>';
                    $message .= 'Votre code de vérification est : ' . $verificationCode . '<br><br>';
                    $message .= 'Cordialement,<br>Votre boutique en ligne';

                    // En-têtes pour envoyer un e-mail HTML
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: Votre boutique en ligne <ostestphp@gmail.com>' . "\r\n"; // Remplacez par votre adresse e-mail

                    // Envoi de l'e-mail
                    $mailSent = mail($to, $subject, $message, $headers);

                    if ($mailSent) {
                        // Stockage du code de vérification dans la base de données
                        $updateVerificationCode = "UPDATE users SET verification_code = '$verificationCode' WHERE id = $currentUserId";
                        $resultUpdateCode = mysqli_query($conn, $updateVerificationCode);

                        if ($resultUpdateCode) {
                            // Redirection vers la page de vérification du code
                            header("Location: command.php");
                            exit();
                        } else {
                            // Gestion d'erreur pour la mise à jour du code de vérification dans la base de données
                        }
                    } else {
                        // Gestion d'erreur pour l'envoi de l'e-mail
                    }
                }



                $query = "SELECT products.id, products.product_name, products.price, products.description, products.product_image, products.quantitate, panier.quantity
          FROM products
          JOIN panier ON products.id = panier.product_id
          WHERE panier.user_id = $currentUserId";

                $result = mysqli_query($conn, $query);

                $totalAmount = 0;
                if ($result && mysqli_num_rows($result) > 0) {
                    echo '<div class="divproduct1">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Affichage des détails du produit
                        echo '<div class="divproduct">';
                        echo '<div class="divpanier">';
                        echo '<h4>' . $row['product_name'] . '</h4>';
                        echo '<div class="image">';
                        echo '<img class="imgpanier" src="' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
                        echo '</div>';
                        echo '<div class="product-details">';
                        echo '<p class="price" >Prix: ' . $row['price'] . ' $</p>';
                        echo '<p>Quantité: ' . $row['quantity'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        // Calcul du montant pour ce produit et ajout au total
                        $productPrice = $row['price'];
                        $productQuantity = $row['quantity'];
                        $productTotal = $productPrice * $productQuantity;
                        $totalAmount += $productTotal;
                    }
                    echo '</div>';
                    echo '<button class="btnback" ><a href="panier.php">Back To Panier</a></button>';
                    echo '<div class ="total-panier">';
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
                    echo '<img src="https://ae01.alicdn.com/kf/Sa15be314eadd4a9bb186ab4a0cb971b5D/360x360.png_.webp" class="es--comet-pro-fallback-image--35CZGig" data-spm-anchor-id="a2g0o.cart.0.i3.3244378d1lo9Se"/>';
                    echo '<p class="no-product-message">Pas encore d\'articles ? Continuez vos achats pour en savoir plus.</p>';
                    echo '<button class="btnback" ><a href="produit1.php">Retour aux produits</a></button>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="column right">
                <h1>Adresse de livraison</h1>
                <h3>Nom de utilisateurs</h3>
                <p>Telephone : 066666666</p>
                <p>Adressse : aaaaaaaaaaaaaaaaaaaaaaaa</p>
                <img class="safe-info-img" src="photo/mouse1.jpg" style="width: 100px; height:auto;">
                <!-- Formulaire d'achat -->
                <form method="post">
                    <!-- Vos champs de formulaire pour l'achat -->
                    <!-- ... -->
                    <!-- Bouton pour confirmer l'achat -->
                    <button type="submit" name="confirm_purchase">Confirmer l'Achat</button>
                </form>
                <!-- Content for the right column -->
                <!-- Add your content here -->
            </div>
        </div>



    </body>

    </html>

<?php
}
?>
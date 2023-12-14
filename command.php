<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['email'])) {
    header('location:login.php');
    exit();
} else {
?>

    <?php

    require_once('connection.php');

    $userid = $_SESSION['id'];
    $queryUser = "SELECT * FROM users WHERE id = '$userid'";
    $resultUser = mysqli_query($conn, $queryUser);
    $rowUser = mysqli_fetch_assoc($resultUser);

    $query = "SELECT products.product_name, products.price, panier.quantity
                FROM products
                JOIN panier ON products.id = panier.product_id
                WHERE panier.user_id = '$userid'";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = [
                'product_name' => $row['product_name'],
                'price' => $row['price'],
                'quantity' => $row['quantity']
            ];
        }
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
        try {
            $mail = new PHPMailer(true); 

            $verificationCode = substr(md5(uniqid(mt_rand(), true)), 0, 8);

            $email = $_SESSION['email'];

            $query = "INSERT INTO orders(user_id, email, token) VALUES ('$userid', '$email', '$verificationCode')";

            $result = mysqli_query($conn, $query);

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ezzahriraja@gmail.com'; 
            $mail->Password   = 'rljdsyklshfeodap'; 
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('EZZAHRIos@gmail.com', 'Gaming Planet');
            $mail->addAddress($rowUser['Email']);

            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";

            $subject = 'Confirmation de votre achat';
            $body = '
    <html>
    <head>
        <title>Confirmation de votre achat</title>
    </head>
    <body>
        <p>Bonjour ' . $rowUser['Username'] . ',</p>
        <p>Merci pour votre achat sur notre boutique en ligne.</p>
                <p>Votre code de vérification est : ' . $verificationCode . '</p>
                <p>Nous vous remercions de votre confiance et restons à votre disposition pour toute question.</p>
                <p>Cordialement,<br><b>Gaming Planet</b></p>
            </body>
            </html>';

            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = 'Pour voir ce message, veuillez utiliser un client de messagerie compatible HTML.';
            $mail->isHTML(true);


            $mail->send();
        } catch (Exception $e) {
            echo "L'envoi de l'e-mail a échoué. Erreur : {$mail->ErrorInfo}";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="command.css">
        <title>Validation de commande</title>
    </head>

    <body>
        <div class="container">
            <form method="post">
                <label for="code-verification">Veuillez saisir votre code verification pour confirmez votre commande : </label>
                <input type="text" name="code-verification" id="code-verification">
                <button type="submit" name="confirm_purchase-final">Confirmer l'Achat</button>
            </form>
        </div>


        <?php
        $message = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase-final'])) {
            $queryOrders = "SELECT * FROM orders WHERE user_id = '$userid' ORDER BY id DESC LIMIT 1";;
            $resultOrders = mysqli_query($conn, $queryOrders);
            $rowOrders = mysqli_fetch_assoc($resultOrders);
            $token = $rowOrders['token'];
            $verificationCodeInput = $_POST['code-verification'];

            if ($token === $verificationCodeInput) {
                $mail = new PHPMailer(true); 
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'ezzahriraja@gmail.com'; 
                $mail->Password   = 'rljdsyklshfeodap'; 
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                $mail->setFrom('ezzahrios@gmail.com', 'Gaming Planet');
                $mail->addAddress($rowUser['Email']);

                $mail->isHTML(true);
                $mail->CharSet = "UTF-8";

                $subject = 'Confirmation de votre achat';
                $body = '
                        <html>
                        <head>
                            <title>Facture de votre achat</title>
                        </head>
                        <body>
                            <div class="header" style="
                                background-color: black;
                                color: #0dff00;
                                width: 100%;
                                height: 40px;
                                padding: 10px;
                                font-size: 25px;
                                font-weight: bold;
                                text-align: center;
                            ">GamingPlanet</div>
                            <p>Bonjour ' . $rowUser['Username'] . ',</p>
                            <p>Merci pour votre achat sur notre boutique en ligne <b>GamingPlanet</b>.</p>
                            <p>Voici un récapitulatif de votre commande :</p>
                            <p>La date de validation de la commande : '. $rowOrders['Purchased_on'] .'</p>
                            <p>Les produits que vous avez achete avec lors prix :</p>
                            <table cellspacing="0" style="width:100%; border: 1px solid #ccc;">
                                <thead>
                                    <tr style="background-color: #f2f2f2;">
                                        <th style="padding: 10px; border: 1px solid #ccc;">Produit</th>
                                        <th style="padding: 10px; border: 1px solid #ccc;">prix de chaque produit</th>
                                        <th style="padding: 10px; border: 1px solid #ccc;">Quantité</th>
                                        <th style="padding: 10px; border: 1px solid #ccc;">Prix total</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $totalAmount = 0;

                foreach ($products as $product) {
                    $productTotal = $product['price'] * $product['quantity'];
                    $body .= '
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['product_name'] . '</td>
                                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['price'] . '</td>
                                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['quantity'] . '</td>
                                        <td style="padding: 10px; border: 1px solid #ccc;">' . $productTotal . '</td>
                                    </tr>';
                    $totalAmount += $productTotal;
                }

                $body .= '
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #ccc;"><strong>Total</strong></td>
                                        <td style="padding: 10px; border: 1px solid #ccc;"><strong>' . $totalAmount . '</strong></td>
                                        <td style="padding: 10px; border: 1px solid #ccc;"></td>
                                    </tr>';

                $body .= '
                                </tbody>
                            </table>
                            <p>Nous vous remercions de votre confiance et restons à votre disposition pour toute question.</p>
                            <p>Cordialement,<br><b>Gaming Planet</b></p>
                        </body>
                        </html>';


                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AltBody = 'Pour voir ce message, veuillez utiliser un client de messagerie compatible HTML.';
                $mail->isHTML(true);



                $mail->send();


                $namesStringWithQuantity = '';

                foreach ($products as $product) {
                    $nameWithQuantity = $product['product_name'] . ' (' . $product['quantity'] . ')';
                    $namesStringWithQuantity .= $nameWithQuantity . ",\n";
                }

                $namesStringWithQuantity = rtrim($namesStringWithQuantity, ",\n");


                $queryUpdate = "UPDATE orders 
                                SET username = '" . $rowUser['Username'] . "', number = '" . $rowUser['numero_telephone'] . "', address = '" . $rowUser['adresse'] . "', names_products = '$namesStringWithQuantity', total_price = '$totalAmount'
                                WHERE token = '$token'";
                $resultUpdate = mysqli_query($conn, $queryUpdate);

                $message = "La commande est validé avec succès!";
                foreach ($products as $product) {
                    $productName = $product['product_name'];
                    $quantityPurchased = $product['quantity'];

                    $queryUpdateQuantity = "UPDATE products 
                            SET quantitate = quantitate - '$quantityPurchased'
                            WHERE product_name = '$productName'";

                    $resultUpdateQuantity = mysqli_query($conn, $queryUpdateQuantity);
                }

                $querySelect = "SELECT * FROM orders WHERE token = '$token'";
                $resultSelect = mysqli_query($conn, $querySelect);

                if ($resultSelect && mysqli_num_rows($resultSelect) > 0) {
                    $rowSelect = mysqli_fetch_assoc($resultSelect);

                    $userId = $rowSelect['user_id'];
                    $commandId = $rowSelect['id'];
                    $dateCommande = $rowSelect['Purchased_on'];
                    $detailsCommande = $rowSelect['names_products'];
                    $prixTotal = $rowSelect['total_price'];
                    $etatCommande = $rowSelect['livraison_status']; 
                    $methodePaiement = $rowSelect['method_payment']; 
                    $adresseLivraison = $rowSelect['address'];

                    $queryInsert = "INSERT INTO historique (user_id, commande_id, date_commande, details_commande, prix_total, etat_commande, methode_paiement, adresse_livraison) 
                    VALUES ('$userId', '$commandId', '$dateCommande', '$detailsCommande', '$prixTotal', '$etatCommande', '$methodePaiement', '$adresseLivraison')";

                    $resultInsert = mysqli_query($conn, $queryInsert);
                    if ($resultInsert) {
                        $queryDelete = "DELETE FROM panier WHERE user_id = '$userId'";
                        $resultDelete = mysqli_query($conn, $queryDelete);
                    }
                }
                echo '
                   <script>
                        setTimeout(function(){window.location.href = "home.php";}, 2500);
                   </script>';
            } else {
                $message = "Le code de vérification est incorrect. Veuillez réessayer.";
            }
        }

        if (!empty($message)) : ?>
            <div class="message error">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>


    </body>

    </html>

<?php
}
?>
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

    // Votre logique de récupération de données utilisateur
    $userid = $_SESSION['id'];
    $queryUser = "SELECT * FROM users WHERE id = '$userid'";
    $resultUser = mysqli_query($conn, $queryUser);
    $rowUser = mysqli_fetch_assoc($resultUser);

    // Supposons que $currentUserId contient l'ID de l'utilisateur actuel
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
        // Utilisez maintenant $products pour construire le contenu de l'email
    } else {
        // Gérer le cas où aucun produit n'est trouvé dans la commande
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
        try {
            $mail = new PHPMailer(true); // Créer une instance de PHPMailer

            // Génération d'un code de vérification
            $verificationCode = substr(md5(uniqid(mt_rand(), true)), 0, 8);

            $email = $_SESSION['email'];

            // Insertion du code de vérification dans la base de données
            // Utilisation sécurisée des valeurs échappées dans une requête SQL
            $query = "INSERT INTO orders(user_id, email, token) VALUES ('$userid', '$email', '$verificationCode')";

            // Exécution de la requête
            $result = mysqli_query($conn, $query);

            // Configuration et envoi de l'e-mail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Configurez votre serveur SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ezzahriraja@gmail.com'; // Remplacez par votre adresse Gmail
            $mail->Password   = 'rljdsyklshfeodap'; // Utilisez le mot de passe d'application généré
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('ezzahrios@gmail.com', 'Gaming Planet');
            $mail->addAddress($rowUser['Email']);

            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            // Supposons que $products contient les détails de chaque produit de la commande

            // ... votre code existant ...

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
        <title>Payment</title>
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase-final'])) {
            $queryOrders = "SELECT token FROM orders WHERE user_id = '$userid'";
            $resultOrders = mysqli_query($conn, $queryOrders);
            $rowOrders = mysqli_fetch_assoc($resultOrders);
            $token = $rowOrders['token'];
            $verificationCode = $_POST['code-verification']; // ou récupérez-le d'où vous l'obtenez

            if ($token === $verificationCode) {
                $mail = new PHPMailer(true); // Créer une instance de PHPMailer
                // Configuration et envoi de l'e-mail
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Configurez votre serveur SMTP
                $mail->SMTPAuth   = true;
                $mail->Username   = 'ezzahriraja@gmail.com'; // Remplacez par votre adresse Gmail
                $mail->Password   = 'rljdsyklshfeodap'; // Utilisez le mot de passe d'application généré
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                $mail->setFrom('ezzahrios@gmail.com', 'Gaming Planet');
                $mail->addAddress($rowUser['Email']);

                $mail->isHTML(true);
                $mail->CharSet = "UTF-8";
                // Supposons que $products contient les détails de chaque produit de la commande

                // ... votre code existant ...

                $subject = 'Confirmation de votre achat';
                $body = '
                        <html>
                        <head>
                            <title>Confirmation de votre achat</title>
                        </head>
                        <body>
                            <p>Bonjour ' . $rowUser['Username'] . ',</p>
                            <p>Merci pour votre achat sur notre boutique en ligne.</p>
                            <p>Voici un récapitulatif de votre commande :</p>
                            <table cellspacing="0" style="width:100%; border: 1px solid #ccc;">
                                <thead>
                                    <tr style="background-color: #f2f2f2;">
                                        <th style="padding: 10px; border: 1px solid #ccc;">Produit</th>
                                        <th style="padding: 10px; border: 1px solid #ccc;">Prix</th>
                                        <th style="padding: 10px; border: 1px solid #ccc;">Quantité</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $totalAmount = 0;

                foreach ($products as $product) {
                    $productTotal = $product['price'] * $product['quantity'];
                    $body .= '
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['product_name'] . '</td>
                                        <td style="padding: 10px; border: 1px solid #ccc;">' . $productTotal . '</td>
                                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['quantity'] . '</td>
                                    </tr>';
                    $totalAmount += $productTotal;
                }

                // Ajouter une ligne pour afficher le prix total
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

                echo '<div> La commande est valide !';
                echo '</div>';

                // Initialisation de la chaîne pour stocker les noms des produits avec leur quantité
                $namesStringWithQuantity = '';

                // Parcours des produits pour récupérer les noms avec leur quantité
                foreach ($products as $product) {
                    $nameWithQuantity = $product['product_name'] . ' (' . $product['quantity'] . ')';
                    $namesStringWithQuantity .= $nameWithQuantity . ",\n";
                }

                // Suppression de la virgule et du retour à la ligne à la fin de la chaîne
                $namesStringWithQuantity = rtrim($namesStringWithQuantity, ",\n");


                $queryUpdate = "UPDATE orders 
                                SET username = '" . $rowUser['Username'] . "', number = '" . $rowUser['numero_telephone'] . "', address = '" . $rowUser['adresse'] . "', names_products = '$namesStringWithQuantity', total_price = '$totalAmount'
                                WHERE token = '$token'";
                $resultUpdate = mysqli_query($conn, $queryUpdate);
            } else {
                echo '<div>Le code de vérification est incorrect. Veuillez réessayer.</div>';
            }
        }
        ?>
    </body>

    </html>

<?php
}
?>
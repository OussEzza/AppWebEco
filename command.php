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



    // Votre code PHPMailer ici...



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
            // $stmt = $conn->prepare("INSERT INTO commandes (code, email) VALUES (?, ?)");
            // $stmt->bind_param("ss", $verificationCode, $row['Email']);
            // $stmt->execute();
            // $stmt->close();

            // Configuration et envoi de l'e-mail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Configurez votre serveur SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ezzahriraja@gmail.com'; // Remplacez par votre adresse Gmail
            $mail->Password   = 'rljdsyklshfeodap'; // Utilisez le mot de passe d'application généré
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('ezzahriraja@gmail.com', 'Votre boutique en ligne');
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

            foreach ($products as $product) {
                $body .= '
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['product_name'] . '</td>
                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['price'] * $product['quantity'] . '</td>
                        <td style="padding: 10px; border: 1px solid #ccc;">' . $product['quantity'] . '</td>
                    </tr>';
            }

            $body .= '
            </tbody>
                </table>
                <p>Votre code de vérification est : ' . $verificationCode . '</p>
                <p>Nous vous remercions de votre confiance et restons à votre disposition pour toute question.</p>
                <p>Cordialement,<br>Votre boutique en ligne</p>
            </body>
            </html>';

            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = 'Pour voir ce message, veuillez utiliser un client de messagerie compatible HTML.';
            $mail->isHTML(true);

   

            $mail->send();

            // Reste du traitement après l'envoi de l'e-mail
            // ...

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
        <link rel="stylesheet" href="stylepayment.css">
        <title>Payment</title>
    </head>

    <body>
        <div class="container">
            <div class="column left">
                <!-- Le reste de votre contenu HTML -->
                <!-- ... -->
                <form method="post">
                    <!-- Vos champs de formulaire pour l'achat -->
                    <!-- ... -->
                    <!-- Bouton pour confirmer l'achat -->
                    <button type="submit" name="confirm_purchase">Confirmer l'Achat</button>
                </form>
                <!-- Content for the left column -->
                <!-- ... -->
            </div>
            <div class="column right">
                <h1>Adresse de livraison</h1>
                <!-- Ajoutez ici les détails de livraison -->
                <!-- ... -->
                <!-- Content for the right column -->
                <!-- ... -->
            </div>
        </div>
    </body>

    </html>

<?php
}
?>
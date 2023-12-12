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

                $message = "La commande est validé avec succès!";

                $querySelect = "SELECT * FROM orders WHERE token = '$token'";
                $resultSelect = mysqli_query($conn, $querySelect);

                if ($resultSelect && mysqli_num_rows($resultSelect) > 0) {
                    $rowSelect = mysqli_fetch_assoc($resultSelect);

                    $userId = $rowSelect['user_id'];
                    $commandId = $rowSelect['id'];
                    $dateCommande = $rowSelect['Purchased_on'];
                    $detailsCommande = $rowSelect['names_products'];
                    $prixTotal = $rowSelect['total_price'];
                    $etatCommande = $rowSelect['livraison_status']; // Mettez l'état approprié de la commande
                    $methodePaiement = $rowSelect['method_payment']; // Mettez la méthode de paiement appropriée
                    $adresseLivraison = $rowSelect['address'];

                    // Requête d'insertion dans la table historique_achat
                    $queryInsert = "INSERT INTO historique (user_id, commande_id, date_commande, details_commande, prix_total, etat_commande, methode_paiement, adresse_livraison) 
                    VALUES ('$userId', '$commandId', '$dateCommande', '$detailsCommande', '$prixTotal', '$etatCommande', '$methodePaiement', '$adresseLivraison')";

                    $resultInsert = mysqli_query($conn, $queryInsert);
                    if ($resultInsert) {
                        $queryDelete = "DELETE FROM panier WHERE user_id = '$userId'";
                        $resultDelete = mysqli_query($conn, $queryDelete);
                        // Supprimez la commande de la table orders si nécessaire
                        // Exemple : DELETE FROM orders WHERE token = '$token';
                    } else {
                        // Gérer l'échec de l'insertion dans l'historique
                    }
                } else {
                    // Gérer le cas où la commande n'est pas trouvée dans la table orders
                }
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
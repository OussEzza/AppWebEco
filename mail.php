<?php
session_start();

require_once('connection.php');
require 'vendor/autoload.php'; // Assurez-vous d'inclure les dépendances avant d'utiliser PHPMailer

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
// if (!isset($_SESSION['username'])) {
//     header('location:login.php');
//     exit(); // Assurez-vous de sortir après avoir redirigé
// }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Votre logique de récupération de données utilisateur
$userid = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = '$userid'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
    try {
        $mail = new PHPMailer(true); // Créer une instance de PHPMailer

        // Génération d'un code de vérification
        $verificationCode = substr(md5(uniqid(mt_rand(), true)), 0, 8);

        // Insertion du code de vérification dans la base de données
        $stmt = $conn->prepare("INSERT INTO commandes (code, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $verificationCode, $row['Email']);
        $stmt->execute();
        $stmt->close();

        // Configuration et envoi de l'e-mail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Configurez votre serveur SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'votre_mail@gmail.com'; // Remplacez par votre adresse Gmail
        $mail->Password   = 'votre_password'; // Utilisez le mot de passe d'application généré
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('votre_mail@gmail.com', 'Votre boutique en ligne');
        $mail->addAddress($row['Email']);

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = 'Confirmation de votre achat';
        $mail->Body    = 'Bonjour ' . $row['Username'] . ',<br><br>'
            . 'Merci pour votre achat.<br>'
            . 'Votre code de vérification est : ' . $verificationCode . '<br><br>'
            . 'Cordialement,<br>Votre boutique en ligne';

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

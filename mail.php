<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ostestphp@gmail.com'; // Remplacez par votre adresse Gmail
    $mail->Password   = 'rnjjgfshtzwlxymn'; // Utilisez le mot de passe d'application généré
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('ostestphp@gmail.com', 'Votre Nom');
    $mail->addAddress('ezzahriraja@gmail.com');

    $mail->isHTML(true);
    $mail->CharSet = "UTF-8";
    $mail->Subject = 'Test message';
    $mail->Body    = 'Test from os <b>PHP MAILER</b>';

    $mail->send();
    echo 'Email envoyé avec succès !';
} catch (Exception $e) {
    echo "L'envoi de l'email a échoué. Erreur : {$mail->ErrorInfo}";
}
?>

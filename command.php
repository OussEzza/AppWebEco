<?php
require_once('mail.php'); // Inclure le fichier qui envoie l'email

// Ici, vous pouvez ajouter d'autres traitements ou actions nécessaires pour votre application

// Par exemple, si vous souhaitez effectuer des opérations après l'envoi de l'email

// Envoyer l'email
try {
    $mail->send();
    echo 'Email envoyé avec succès !';
} catch (Exception $e) {
    echo "L'envoi de l'email a échoué. Erreur : {$mail->ErrorInfo}";
}

// Autres traitements ou actions
?>

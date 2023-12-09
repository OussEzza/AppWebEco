<!DOCTYPE html>
<html>

<head>
    <title>Page d'achat</title>
    <style>
        /* Style pour le corps de la page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        /* Style pour les titres */
        h1,
        h2 {
            color: #333;
        }

        /* Style pour le formulaire */
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"] {
            width: calc(100% - 12px);
            padding: 6px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>Votre Panier</h1>
    <div>
        <!-- Affichage des produits depuis le panier -->
        <!-- Ici, vous devrez afficher les produits ajoutés au panier -->
    </div>

    <h2>Informations Personnelles</h2>
    <form method="post">
        <!-- Formulaire pour les informations personnelles -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <!-- Autres champs pour les informations personnelles -->

        <!-- Bouton pour procéder au paiement -->
        <input type="submit" name="checkout" value="Procéder au paiement">
    </form>
</body>

</html>


<?php

require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkout'])) {
        // Générer un code aléatoire
        $code = mt_rand(100000, 999999); // Exemple de génération d'un code à 6 chiffres

        // Récupérer l'email depuis le formulaire
        $email = $_POST['email'];
 
        // Insérer le code dans la base de données avec l'email associé
        $sql = "INSERT INTO commandes (email, code) VALUES ('$email', '$code')";
        if ($conn->query($sql) === TRUE) {
            // Envoi de l'email
            $subject = "Code de confirmation de commande";
            $message = "Votre code de confirmation est : $code";
            $headers = "From: ezzahrioussama01@gmail.com"; // Remplacez par votre adresse email

            $emailreponse = mail($email, $subject, $message, $headers);
            if ($emailreponse) {
                echo "Code envoyé avec succès à votre email.";
            } else {
                echo "L'envoi du code a échoué.";
            }
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    }
}

?>
<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "user1";
$password = "user1";
$dbname = "ShoppingPlanet";

// Initialisation du tableau d'erreurs
$errors = array(
    "nom_utilisateur" => "",
    "numero_telephone" => "",
    "adresse" => "",
    "email" => "",
    "motDePasse" => "",
    "confirmMotDePasse" => ""
);

// Vérification si le formulaire d'inscription est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["s'inscrire"])) {
    // Validation des données (ajoutez vos propres règles de validation)
    $nomUtilisateur = $_POST['nom_utilisateur'];
    $numeroTelephone = $_POST['numero_telephone'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];
    $confirmMotDePasse = $_POST['confirmMotDePasse'];

    // Ajoutez des vérifications pour chaque champ du formulaire
    if (empty($nomUtilisateur)) {
        $errors["nom_utilisateur"] = "Veuillez entrer votre nom d'utilisateur.";
    }

    if (empty($numeroTelephone)) {
        $errors["numero_telephone"] = "Veuillez entrer votre numéro de téléphone.";
    }

    if (empty($adresse)) {
        $errors["adresse"] = "Veuillez entrer votre adresse.";
    }

    if (empty($email)) {
        $errors["email"] = "Veuillez entrer votre adresse e-mail.";
    }

    if (empty($motDePasse)) {
        $errors["motDePasse"] = "Veuillez entrer votre mot de passe.";
    }

    if ($motDePasse !== $confirmMotDePasse) {
        $errors["confirmMotDePasse"] = "Les mots de passe ne correspondent pas.";
    }

    if (empty(array_filter($errors))) {
        // Connexion à la base de données
        $connexion = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($connexion->connect_error) {
            die("La connexion à la base de données a échoué : " . $connexion->connect_error);
        }

        // Utilisation de déclarations préparées pour éviter les injections SQL
        $stmt = $connexion->prepare("INSERT INTO utilisateur (nom_utilisateur, adresse, numero_telephone, email, motDePasse) VALUES (?, ?, ?, ?, ?)");

        // Vérification de la préparation de la requête
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $connexion->error);
        }

        $stmt->bind_param("ssiss", $nomUtilisateur, $adresse, $numeroTelephone, $email, $motDePasse);

        if ($stmt->execute()) {
            // Inscription réussie
            echo json_encode(array("success" => true, "message" => "Inscription réussie. Bienvenue !"));
        } else {
            // Erreur lors de l'inscription
            echo json_encode(array("success" => false, "message" => "Une erreur s'est produite lors de l'inscription. Veuillez réessayer."));
        }

        $stmt->close();
        $connexion->close();
    } else {
        // Erreurs de validation
        echo json_encode(array("success" => false, "errors" => $errors));
    }
}
?>
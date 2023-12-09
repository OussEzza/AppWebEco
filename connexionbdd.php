<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "user1";
$password = "user1";
$dbname = "ShoppingPlanet";

// Vérification si le formulaire de connexion est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["connexion"])) {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];

    // Connexion à la base de données
    $connexion = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($connexion->connect_error) {
        die("La connexion à la base de données a échoué : " . $connexion->connect_error);
    }

    // Utilisation de déclarations préparées pour éviter les injections SQL
    $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE email = ?");

    // Vérification de la préparation de la requête
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $connexion->error);
    }

    $stmt->bind_param("s", $email);

    // Exécution de la requête
    if (!$stmt->execute()) {
        // Afficher le message d'erreur SQL
        die(json_encode(array("success" => false, "message" => "Erreur SQL : " . $stmt->error)));
    }

    // Récupération des résultats
    $result = $stmt->get_result();
    $utilisateur = $result->fetch_assoc();

    // Vérification du mot de passe
    if ($utilisateur && $motDePasse == $utilisateur['motDePasse']) {
        // Authentification réussie
        echo json_encode(array("success" => false, "message" => "bienvenu"));
       
    } else {
        // Mot de passe incorrect ou utilisateur non trouvé
        echo json_encode(array("success" => false, "message" => "Adresse e-mail ou mot de passe incorrect."));
    }

    // Fermeture des ressources
    $stmt->close();
    $connexion->close();
}
?>

<?php
// Informations de connexion à la base de données
$servername = "localhost"; // Nom du serveur MySQL
$username = "user1"; // Votre nom d'utilisateur MySQL
$password = "user1"; // Votre mot de passe MySQL
$dbname = "shoppingplanet"; // Nom de votre base de données

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>

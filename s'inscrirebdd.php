<?php
// Démarrer la session
session_start();

// Informations de connexion à la base de données
$servername = "localhost";
$username = "user1";
$password = "user1";
$dbname = "ShoppingPlanet";

// Connexion à la base de données
$connexion = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Échapper les entrées pour éviter les injections SQL
    $email = mysqli_real_escape_string($connexion, $_POST['email']);
    $password = mysqli_real_escape_string($connexion, $_POST['password']);
    $usertype = $_POST['usertype'];

    // Requête SQL pour récupérer l'utilisateur en fonction de l'email
    $result = mysqli_query($connexion, "SELECT * FROM users WHERE Email='$email'") or die(mysqli_error($connexion));
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $hashpass = $row['Password'];

        // Vérifier le mot de passe avec la fonction password_verify
        if (password_verify($password, $hashpass)) {
            $_SESSION['valid'] = $row['Email'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['id'] = $row['Id'];
            $_SESSION['usertype'] = $usertype;

            // Rediriger en fonction du type d'utilisateur
            if ($_SESSION['usertype'] === 'admin') {
                header("Location: desk.php");
            } else {
                header("Location: home.php");
            }
        } else {
            // Afficher un message d'erreur si le mot de passe est incorrect
            echo "<div class='alert alert-danger'>
                    <p>Identifiant ou mot de passe incorrect</p>
                  </div>";
            echo "<a href='login.php' class='btn btn-primary'>Retour</a>";
        }
    } else {
        // Afficher un message d'erreur si l'utilisateur n'est pas trouvé
        echo "<div class='alert alert-danger'>
                <p>Identifiant ou mot de passe incorrect</p>
              </div>";
        echo "<a href='login.php' class='btn btn-primary'>Retour</a>";
    }
}
?>

<!-- Le reste du code HTML... -->

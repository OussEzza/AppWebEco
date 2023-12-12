<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
    exit(); // Assurez-vous de terminer le script après la redirection
} else {
    require_once('connection.php');
}

// Vérifier si l'ID de l'utilisateur administrateur est passé dans l'URL
if ($_SESSION['type'] === 'admin') {
    $adminId = $_SESSION['id'];
    $selectQuery = "SELECT * FROM users WHERE Id = '$adminId'";
    $result = mysqli_query($conn, $selectQuery);

    echo '<div class="container">';
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Affichage des informations de l'utilisateur administrateur dans le formulaire
        echo "<div class='profile'>
            <h1 class='card-title text-center mb-4 gradient-title'>PROFIL</h1>
            <form action='profil.php' method='post'>
                <!-- Ajoutez les champs nécessaires ici avec les valeurs récupérées depuis la base de données -->
                <div class='mb-3'>
                    <label for='username' class='form-label'>Nom d'utilisateur</label>
                    <input type='text' name='username' id='username' class='form-control' autocomplete='off' value='" . $row['Username'] . "' required>
                </div>
                <div class='mb-3'>
                    <label for='email' class='form-label'>Email</label>
                    <input type='text' name='email' id='email' class='form-control' autocomplete='off' value='" . $row['Email'] . "' required>
                </div>
                <div class='mb-3'>
                    <label for='adresse' class='form-label'>Adresse</label>
                    <input type='text' name='adresse' id='adresse' class='form-control' autocomplete='off' value='" . $row['adresse'] . "' required>
                </div>
                <div class='mb-3'>
                    <label for='numero_telephone' class='form-label'>Numéro de téléphone</label>
                    <input type='number' name='numero_telephone' id='numero_telephone' class='form-control' autocomplete='off' value='" . $row['numero_telephone'] . "' required>
                </div>
                <!-- Ajoutez les champs restants ici avec les valeurs récupérées depuis la base de données -->

                <div class='mb-3 text-center'>
                    <button type='submit' class='btn btn-primary btn-lg' name='submit'>Mettre à jour</button>
                </div>
            </form> 
        </div>";
    } else {
        echo 'Utilisateur administrateur non trouvé.';
    }
    echo '</div>';
}

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Récupérer les nouvelles valeurs depuis le formulaire
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newAdresse = mysqli_real_escape_string($conn, $_POST['adresse']);
    $newPhoneNumber = mysqli_real_escape_string($conn, $_POST['numero_telephone']);

    // Mettre à jour les données dans la base de données
    $updateQuery = "UPDATE users SET Username='$newUsername', Email='$newEmail', adresse='$newAdresse', numero_telephone='$newPhoneNumber' WHERE Id = '$adminId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo 'Informations mises à jour avec succès.';
    } else {
        echo 'Erreur lors de la mise à jour des informations: ' . mysqli_error($conn);
    }
}
?>

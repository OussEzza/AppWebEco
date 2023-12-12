<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location:login.php');
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="profil.css">
        <title>Profile</title>
    </head>

    <body>
        <?php
        require_once('connection.php');
        $userid = $_SESSION['id'];

        // Vérifier si le formulaire a été soumis pour mettre à jour les données
        if (isset($_POST['submit'])) {
            // Récupérer les nouvelles valeurs depuis le formulaire
            $newUsername = $_POST['username'];
            $newAdresse = $_POST['adresse'];
            $newPhoneNumber = $_POST['numero_telephone'];
            $newEmail = $_POST['email'];

            // Mettre à jour les données dans la base de données
            // (Vous devriez utiliser des requêtes préparées pour des raisons de sécurité)
            $updateQuery = "UPDATE users SET Username='$newUsername', adresse='$newAdresse', numero_telephone='$newPhoneNumber', Email='$newEmail' WHERE Id = '$userid'";
            $result = mysqli_query($conn, $updateQuery);

            if ($result) {
                // echo "Les informations ont été mises à jour avec succès.";
            } else {
                // echo "Erreur lors de la mise à jour des informations: " . $conn->error;
            }
        }

        // Récupérer les informations de l'utilisateur depuis la base de données
        $selectQuery = "SELECT * FROM users WHERE Id = '$userid'";
        $result = mysqli_query($conn, $selectQuery);

        echo '<div class="container">';
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Affichage des informations de l'utilisateur dans le formulaire
                
                echo "<div class='profile'>
                <h1 class='card-title text-center mb-4 gradient-title'>PROFIL</h1>
                <form action='profil.php' method='post'>
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
                }
            }
            echo '<div class="historique" >';
            echo '<h1>Historique</h1>';
            // Code pour récupérer l'historique depuis la base de données
            
            $query = "SELECT * FROM historique WHERE user_id = '$userid'";
            $result = mysqli_query($conn, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<thead><tr><th>Commande ID</th><th>Date de commande</th><th>Détails de la commande</th><th>Prix Total</th><th>État de la commande</th><th>Méthode de paiement</th><th>Adresse de livraison</th></tr></thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['commande_id'] . '</td>';
                    echo '<td>' . $row['date_commande'] . '</td>';
                    echo '<td>' . $row['details_commande'] . '</td>';
                    echo '<td>' . $row['prix_total'] . '</td>';
                    echo '<td>' . $row['etat_commande'] . '</td>';
                    echo '<td>' . $row['methode_paiement'] . '</td>';
                    echo '<td>' . $row['adresse_livraison'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'Aucune commande trouvée.';
            }
            
            echo '</div>';



            
            echo '</div>';
        ?>
    </body>

    </html>


<?php
}
?>
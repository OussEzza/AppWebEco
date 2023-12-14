<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="photo/7553408.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .gradient-title {
            background-image: linear-gradient(to right, #FA8BFF, #2BD2FF, #2BFF88);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .error-message {
            color: red;
            margin-top: 5px;
        }
        #but {
        display: flex;
        margin: 5px;
       }
      #but button, #but a {
        flex: 1; /* Cela permet à chaque bouton d'occuper une part égale de l'espace disponible */
        margin: 1px;
          width: 5px;
         height: 50px;
     }

    </style>
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="card p-4 custom-form">
            <div class="card-body">
                <?php
                session_start();
                include("connection.php");

                $usernameErr = $adresseErr = $numero_telephoneErr = $emailErr = $passwordErr = "";

                if (isset($_POST['submit'])) {
                    $nom_utilisateur = $_POST['username'];
                    $email = $_POST['email'];
                    $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $adresse = $_POST['adresse'];
                    $numero_telephone = $_POST['numero_telephone'];

                    // Vérifier si le nom d'utilisateur existe déjà
                    $resultUsername = mysqli_query($conn, "SELECT * FROM users WHERE Username='$nom_utilisateur'");
                    if (mysqli_num_rows($resultUsername) > 0) {
                        $usernameErr = "Le nom d'utilisateur existe déjà.";
                    }
                    if (strpos($email, '@') === false) {
                        $emailErr =  "L'e-mail doit contenir le caractère '@'"; 
                                
                    } else {
                        // Vérifier si l'e-mail existe déjà
                        $resultEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
                        if (mysqli_num_rows($resultEmail) > 0) {
                        $emailErr = "L'e-mail existe déjà.";
                    }
                }
                    if (empty($usernameErr) && empty($emailErr)) {
                        mysqli_query($conn, "INSERT INTO users(Username, numero_telephone, adresse, email, motDePasse) 
                            VALUES('$nom_utilisateur','$numero_telephone','$adresse','$email','$motDePasse')") or die("Erreur");

                        echo "<div class='alert alert-success'>
                                    <p>Inscription réussie !</p>
                                </div>";

                   

                    }
                }
                ?>

                <h1 class="card-title text-center mb-4 gradient-title">INSCRIPTION</h1>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" name="username" id="username" class="form-control" autocomplete="off" required>
                        <span class="error-message"><?php echo $usernameErr; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" id="adresse" class="form-control" autocomplete="off" required>
                        <span class="error-message"><?php echo $adresseErr; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="numero_telephone" class="form-label">Numéro de téléphone</label>
                        <input type="number" name="numero_telephone" id="numero_telephone" value="212" class="form-control" autocomplete="off" required>
                        <span class="error-message"><?php echo $numero_telephoneErr; ?></span>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" name="email" id="email" class="form-control" autocomplete="off" required>
                        <span class="error-message"><?php echo $emailErr; ?></span>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
                        <span class="error-message"><?php echo $passwordErr; ?></span>
                    </div>

                    <div class="mb-3 text-center" id="but">
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">S'inscrire</button>
                        <a href="login.php" class="btn btn-secondary btn-lg btn-success">Se connecter </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

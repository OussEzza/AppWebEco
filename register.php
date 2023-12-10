<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-form {
            max-width: 400px;
            margin: 0 auto;
        }
        .gradient-title {
            background-image: linear-gradient(to right,#FA8BFF,#2BD2FF,#2BFF88);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
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

                if (isset($_POST['submit'])) {
                    $_SESSION['username'] = $nom_utilisateur = $_POST['username'];
                    $_SESSION['email'] = $email = $_POST['email'];
                    $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    $_SESSION['address'] = $adresse = $_POST['adresse'];
                    $_SESSION['phone'] = $numero_telephone = $_POST['numero_telephone'];

                    $verify_query = mysqli_query($conn, "SELECT Email FROM users WHERE Email='$email'");

                    if (mysqli_num_rows($verify_query) != 0) {
                        echo "<div class='alert alert-danger'>
                                    <p>Cet e-mail est déjà utilisé, veuillez en choisir un autre !</p>
                                </div>";
                    } else {
                        mysqli_query($conn, "INSERT INTO users(Username,numero_telephone,adresse,email,motDePasse) 
                          VALUES('$nom_utilisateur','$numero_telephone','$adresse','$email','$motDePasse')") or die("Erreur");

                        echo "<div class='alert alert-success'>
                                    <p>Inscription réussie !</p>
                                </div>";

                        echo"  <div class='text-center'>
                                <a href='login.php' class='btn btn-primary'>Se connecter maintenant</a>
                            </div>";
                    }
                }
                ?>

                <h1 class="card-title text-center mb-4 gradient-title">INSCRIPTION</h1>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" name="username" id="username" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" id="adresse" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero_telephone" class="form-label">Numéro de téléphone</label>
                        <input type="number" name="numero_telephone" id="numero_telephone" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" name="email" id="email" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">S'inscrire</button>
                    </div>
                   

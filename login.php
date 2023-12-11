<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="card mx-auto p-4 custom-form">
            <div class="card-body">
                <?php
                session_start();
                include("connection.php");

                if (isset($_POST['submit'])) {
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']);


                    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'") or die(mysqli_error($conn));
                    $row = mysqli_fetch_assoc($result);

                    $motDePass = $row['motDePasse'];

                    if (password_verify($password, $motDePass)) {
                        $_SESSION['id'] = $row['Id'];
                        $_SESSION['email'] = $row['Email'];
                        // Redirection vers la page d'accueil
                        header("Location: home.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>
                            <p>Adresse e-mail ou mot de passe incorrect</p>
                        </div>";
                        echo "<a href='login.php' class='btn btn-primary'>Retour</a>";
                    }
                }
                ?>

                <h1 class="card-title text-center mb-4 gradient-title">CONNEXION</h1>

                <!-- Ajout de la div pour afficher les erreurs -->
                <div id="error-alert" class="alert alert-danger d-none" role="alert"></div>
                <?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    if ($row && isset($row['motDePasse']) && $password === $row['motDePasse']) {
        $_SESSION['id'] = $row['Id'];
        
        if ($row['type'] === 'admin') {
            header("Location: admin_header.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        // JavaScript pour afficher l'alerte d'erreur
        echo "<script>
                document.getElementById('error-alert').classList.remove('d-none');
                document.getElementById('error-alert').innerHTML = 'Adresse e-mail ou mot de passe incorrect';
              </script>";
    }
}
?>


                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">connexion</button>
                    </div>
                    <div class="text-center">
                        Pas encore de compte ? <a href="register.php">Inscrivez-vous</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

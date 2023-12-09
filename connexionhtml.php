<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css">
    <title>Formulaire d'inscription et de connexion</title>
    <style>
        /* Ajoutez votre CSS personnalisé ici */
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Formulaire de connexion & d’inscription</h1>

    <div class="content">
        <div class="container">
            <img class="bg-img" src="https://mariongrandvincent.github.io/HTML-Personal-website/img-codePen/bg.jpg" alt="">
            <div class="menu">
                <a href="#" class="btn-connexion active">
                    <h2>CONNEXION</h2>
                </a>
                <a href="#" class="btn-enregistrer">
                    <h2>S'INSCRIRE</h2>
                </a>
            </div>

            <div class="form-section connexion active-section">
                <div class="contact-form">
                    <form action="connexionbdd.php" method="POST">
                        <!-- Login (Connexion) Section -->
                        <label>E-MAIL</label>
                        <input placeholder="" type="text" name="email">
                        <span class="error"><?php if (isset($errors["email"])) echo $errors["email"]; ?></span>

                        <label>MOT DE PASSE</label>
                        <input placeholder="" type="password" name="motDePasse">
                        <span class="error"><?php if (isset($errors["motDePasse"])) echo $errors["motDePasse"]; ?></span>

                        <input class="submit" value="connexion" type="submit" name="connexion">
                    </form>
                </div>

                <hr>
                <a href="https://www.grandvincent-marion.fr/" target="_blank">
                    <h4>MOT DE PASSE OUBLIE</h4>
                </a>
            </div>

            <div class="enregistrer active-section">
                <div class="contact-form">
                    <form action="s'inscrirebdd.php" method="POST">
                        <!-- Registration (Inscription) Section -->
                        <label>NOM D'UTILISATEUR</label>
                        <input placeholder="" type="text" name="nom_utilisateur">
                        <span class="error"><?php if (isset($errors["nom_utilisateur"])) echo $errors["nom_utilisateur"]; ?></span>

                        <label>NUMÉRO DE TÉLÉPHONE</label>
                        <input placeholder="" type="text" name="numero_telephone">
                        <span class="error"><?php if (isset($errors["numero_telephone"])) echo $errors["numero_telephone"]; ?></span>

                        <label>ADRESSE</label>
                        <input placeholder="" type="text" name="adresse">
                        <span class="error"><?php if (isset($errors["adresse"])) echo $errors["adresse"]; ?></span>

                        <label>E-MAIL</label>
                        <input placeholder="" type="text" name="email">
                        <span class="error"><?php if (isset($errors["email"])) echo $errors["email"]; ?></span>

                        <label>MOT DE PASSE</label>
                        <input placeholder="" type="password" name="motDePasse">
                        <span class="error"><?php if (isset($errors["motDePasse"])) echo $errors["motDePasse"]; ?></span>

                        <label>CONFIRMER MOT DE PASSE</label>
                        <input placeholder="" type="password" name="confirmMotDePasse">
                        <span class="error"><?php if (isset($errors["confirmMotDePasse"])) echo $errors["confirmMotDePasse"]; ?></span>

                        <input class="submit" value="s'inscrire" type="submit" name="s'inscrire">
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
         
            $('.btn-enregistrer').click(function () {
                $('.connexion').addClass('remove-section');
                $('.enregistrer').removeClass('active-section');
                $('.btn-enregistrer').removeClass('active');
                $('.btn-connexion').addClass('active');
            });

            $('.btn-connexion').click(function () {
                $('.connexion').removeClass('remove-section');
                $('.enregistrer').addClass('active-section');
                $('.btn-enregistrer').addClass('active');
                $('.btn-connexion').removeClass('active');
            });
        </script>
    </div>
</body>

</html>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">

    <style>
      /* Titre de la section messages */ 
      .messages {
         width: 800px;
         margin: 0 auto;
         padding: 20px;
      }
      .title {
         font-size: 24px;
         margin-bottom: 20px;
         color: #333;
         text-align: center;
      }
      /* Boîte de messages individuelle */
      .box {
         background-color: #fff;
         padding: 20px;
         margin-bottom: 20px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         transition: box-shadow 0.3s ease;
      }

      /* Effet de survol sur la boîte de messages */
      .box:hover {
         box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      }

      /* Styles pour chaque élément d'information */
      .box p {
         margin: 10px 0;
         font-size: 16px;
      }

      /* Lien de suppression */
      .delete-btn {
         display: inline-block;
         padding: 8px 16px;
         background-color: #e74c3c;
         color: #fff;
         text-decoration: none;
         border-radius: 5px;
         transition: background-color 0.3s ease;
      }

      /* Effet de survol sur le lien de suppression */
      .delete-btn:hover {
         background-color: #c0392b;
      }

      /* Message pour l'absence de messages */
      .empty {
         text-align: center;
         margin: 20px;
         color: #555;
      }
   </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="messages">
    <h1 class="title"> Messages </h1>
    <div class="box-container">
        <?php
        require 'connection.php';
        session_start();

        // Vérifier si la variable "delete" est définie dans l'URL
        if (isset($_GET['delete'])) {
            // Récupérer l'ID de l'utilisateur à supprimer depuis l'URL
            $user_id_to_delete = $_GET['delete'];

            // Éviter les attaques par injection SQL en utilisant une requête préparée
            $delete_query = mysqli_prepare($conn, "DELETE FROM `message` WHERE user_id = ?");
            mysqli_stmt_bind_param($delete_query, "i", $user_id_to_delete);

            // Exécuter la requête préparée
            if (mysqli_stmt_execute($delete_query)) {
                // Rediriger vers la page des messages après la suppression
                header("Location: admin_contact.php");
                exit();
            } else {
                // Gérer les erreurs de suppression (affichage ou journalisation)
                echo "Erreur lors de la suppression du message.";
            }

            // Fermer la requête préparée
            mysqli_stmt_close($delete_query);
        }

        $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');

        if (mysqli_num_rows($select_message) > 0) {
            while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                ?>
                <div class="box">
                    <p> user id : <span><?php echo $fetch_message['user_id']; ?></span> </p>
                    <p> name : <span><?php echo $fetch_message['name']; ?></span> </p>
                    <p> number : <span><?php echo $fetch_message['number']; ?></span> </p>
                    <p> email : <span><?php echo $fetch_message['email']; ?></span> </p>
                    <p> message : <span><?php echo $fetch_message['message']; ?></span> </p>
                    <a href="admin_contact.php?delete=<?php echo $fetch_message['user_id']; ?>"
                       onclick="return confirm('Supprimer ce message?');" class="delete-btn">supprimer message</a>
                </div>
                <?php
            };
        } else {
            echo '<p class="empty">Pas de messages!</p>';
        }
        ?>
    </div>
</section>

<!-- ... Votre balise script pour le fichier js/admin_script.js ... -->

</body>
</html>

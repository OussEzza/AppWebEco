<?php
include 'connection.php';
session_start();

// Processus de suppression d'utilisateur
if (isset($_GET['delete'])) {
   $delete_id = mysqli_real_escape_string($conn, $_GET['delete']);
   $delete_query = "DELETE FROM `users` WHERE Id = '$delete_id'";
   $delete_result = mysqli_query($conn, $delete_query);

   if ($delete_result) {
      session_destroy();
     header('Location: admin_users.php');
       exit();
   } else {
       echo 'Delete failed: ' . mysqli_error($conn);
   }
}

// Processus de modification d'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
   $edit_id = mysqli_real_escape_string($conn, $_POST['edit_user_id']);
   // Vous pouvez rediriger vers la page d'édition avec l'ID de l'utilisateur
   header("Location: edit_user.php?id=$edit_id");
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMPTES D’UTILISATEURS</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom admin CSS file link -->
    <link rel="stylesheet" href="css/admin_style.css">

    <style>
        body {
            font-family: "Arial", sans-serif;
            background: linear-gradient(to right,  #214a1d, #2ecc71);  
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .users {
            padding: 20px;
        }

        .title {
            text-align: center;
            color: #fff;
        }

        .box-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .box {
            width: 300px;
            background: #fff;  
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); 
            margin: 15px;
            padding: 15px;
            transition: transform 0.3s ease-in-out;
        }

        .box:hover {
            transform: scale(1.05);  
        }

        .box p {
            margin: 0;
            padding: 5px 0;
        }

        .box a {
            display: block;
            background-color: #e74c3c;
            color: #fff;
            text-align: center;
            padding: 8px;
            border-radius: 3px;
            text-decoration: none;
            margin-top: 10px;
        }

        .box a:hover {
            background-color: #c0392b; /* Rouge plus foncé au survol */
        }
    </style>

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="users">

        <h1 class="title">COMPTES D’UTILISATEURS</h1>

        <div class="box-container">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {
            ?>
                <div class="box">
                    <p> User ID: <span><?php echo $fetch_users['Id']; ?></span> </p>
                    <p> Username: <span><?php echo $fetch_users['Username']; ?></span> </p>
                    <p> Email: <span><?php echo $fetch_users['Email']; ?></span> </p>
                    <p> User type: <span style="color:<?php echo ($fetch_users['type'] == 'admin') ? '#e67e22' : '#3498db'; ?>"><?php echo $fetch_users['type']; ?></span> </p>
                    
                    <!-- Formulaire pour le bouton de modification -->
                    <form method="post" action="admin_users.php">
                        <input type="hidden" name="edit_user_id" value="<?php echo $fetch_users['Id']; ?>">
                        <input type="submit" name="edit_user" value="modifier l'utilisateur" style="background-color: #3498db;">
                    </form>
                    
                    <a href="admin_users.php?delete=<?php echo $fetch_users['Id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">supprimer l'utilisateur</a>
                </div>
            <?php
            };
            ?>
        </div>

    </section>

</body>

</html>

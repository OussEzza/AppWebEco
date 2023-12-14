<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">

    <style>
         .messages {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }

        .title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            animation: fadeIn 0.5s ease-in-out;
            opacity: 1;
        }

        th {
            background-color: #8b5a2b;  
            color: #fff; 
        }
 .delete-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .empty {
            text-align: center;
            margin: 20px;
            color: #555;
        }

        .green {
            color: green;
        }

        .return-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: green;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;  
        }

        .return-btn:hover {
            background-color: darkgreen;
        }
        
            .panel .user-text{
                 color: #60dea1;  
              }
       
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
           
        }

        
    </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="messages">
            <section class="users">
           <div class="panel">
              <h1 class="title">MESS<span class="user-text">AGE</span></h1>
            </div>
    <div class="table-container">
    <?php
        require 'connection.php';

        if (isset($_GET['delete'])) {

            $user_id_to_delete = $_GET['delete'];

            $delete_query = mysqli_prepare($conn, "DELETE FROM `message` WHERE id = ?");
            mysqli_stmt_bind_param($delete_query, "i", $user_id_to_delete);

            if (mysqli_stmt_execute($delete_query)) {
                $message = "Message supprimé avec succès.";
                $colorClass = "green";
                echo '<span class="' . $colorClass . '">' . $message . '</span>';
                echo '<a href="admin_contact.php" class="return-btn green">Retour aux Messages</a>';
                exit();
            } else {
                echo "Erreur lors de la suppression du message.";
            }

            mysqli_stmt_close($delete_query);
        }

        $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('Query failed');

        if (mysqli_num_rows($select_message) > 0) {
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
                <?php
                while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                    ?>
                    <tr>
                        <td><?php echo $fetch_message['id']; ?></td>
                        <td><?php echo $fetch_message['name']; ?></td>
                        <td><?php echo $fetch_message['number']; ?></td>
                        <td><?php echo $fetch_message['email']; ?></td>
                        <td><?php echo $fetch_message['message']; ?></td>
                        <td>
                            <a href="admin_contact.php?delete=<?php echo $fetch_message['id']; ?>"
                               onclick="return confirm('Supprimer ce message?');" class="delete-btn">Supprimer</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        } else {
            echo '<p class="empty">Pas de messages!</p>';
        }
        ?>
        
    </div>
</section>

</body>
</html>
<?php

require_once 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
   header('location:login.php');
} else {
   $user_id = $_SESSION['id'];

   require_once('navbar.php');

   if (isset($_POST['send'])) {

      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $number = $_POST['number'];
      $msg = mysqli_real_escape_string($conn, $_POST['message']);

      $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

      if (mysqli_num_rows($select_message) > 0) {
         $messages[] = 'message déjà envoyé !';
      } else {
         mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
         $messages[] = 'message envoyé avec succès!';
      }

      if (isset($messages)) {
         foreach ($messages as $message) {
            echo '<div class="message">
                  <span>' . $message . '</span>
                  </div>';
         }
      }
   }

?>

   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="contact.css">
      <title>Contact</title>

   </head>

   <body>

      <section id="contact">
         <form action="" method="post">
            <h3>say something!</h3>
            <input type="text" name="name" required placeholder="entrer votre nom" class="box">
            <input type="email" name="email" required placeholder="entrer votre email" class="box">
            <input type="number" name="number" required placeholder="entrer votre numéro" class="box">
            <textarea name="message" id="box" placeholder="entrer votre message" id="" cols="30" rows="10"></textarea>
            <input type="submit" value="send message" name="send" id="btn">
         </form>

      </section>



      <?php include 'footer.php'; ?>

      <script>
         const messages = document.querySelectorAll('.message');

         const removeMessage = (message) => {
            setTimeout(() => {
               message.remove(); 
            }, 4000); 
         };

         messages.forEach((message) => {
            message.classList.add('show');

            removeMessage(message);
         });
      </script>

   </body>

   </html>

<?php
}
?>
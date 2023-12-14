<?php

require_once 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
   header('location:login.php');
} else {
   $user_id = $_SESSION['id'];

require_once ('navbar.php');

   if (isset($_POST['send'])) {

      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $number = $_POST['number'];
      $msg = mysqli_real_escape_string($conn, $_POST['message']);

      $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

      if (mysqli_num_rows($select_message) > 0) {
         $message[] = 'message déjà envoyé !';
      } else {
         mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
         $message[] = 'message envoyé avec succès!';
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
            <input type="text" name="name" required placeholder="enter your name" class="box">
            <input type="email" name="email" required placeholder="enter your email" class="box">
            <input type="number" name="number" required placeholder="enter your number" class="box">
            <textarea name="message" id="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
            <input type="submit" value="send message" name="send" id="btn">
         </form>

      </section>








      <?php include 'footer.php'; ?>

      <!-- custom js file link  -->
      <script>
         // Sélectionnez tous les éléments ayant la classe "message"
         const messages = document.querySelectorAll('.message');

         // Parcourez chaque élément et planifiez sa suppression après 3 secondes
         messages.forEach((message) => {
            // Utilisez setTimeout pour définir un délai de 3 secondes avant de masquer le message
            setTimeout(() => {
               // Ajoutez une classe pour cacher le message avec une transition CSS
               message.classList.add('hide-message');

               // Attendez la fin de la transition CSS, puis supprimez complètement l'élément du DOM
               message.addEventListener('transitionend', () => {
                  message.remove();
               }, {
                  once: true // Le gestionnaire d'événements ne sera appelé qu'une seule fois
               });
            }, 3000); // 3000 millisecondes = 3 secondes
         });
      </script>

   </body>

   </html>

<?php
}
?>
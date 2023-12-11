<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<html>
<!-- admin_header.php -->
<link rel="stylesheet" href="admin_page.css">
<header class="header">
    <div class="flex">
        <a href="<?php echo $_SESSION['type'] === 'admin' ? 'admin_page.php' : 'home.php'; ?>" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="admin_page.php">Accueil</a>
            <a href="admin_produits.php">Produits</a>
            <a href="admin_orders.php">Commandes</a>
            <a href="admin_users.php">Utilisateurs</a>
            <a href="admin_contacts.php">Messages</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
    </div>
</header>
<body>



</body>

<script src=" admin .js"></script>
</html>
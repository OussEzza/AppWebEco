<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Command</title>
    </head>

    <body>
        <h1>Code envoyer avec succes !</h1>
    </body>

    </html>

<?php
}
?>
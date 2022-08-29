<?php
session_start();
include_once('class/class.header.php');
if($_SESSION['username'] == "")
{
    header('Location: /login.php');
}
else if(user_is_actif() !== 'true')
{
    header('Location: logout.php');
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <section class="section">
    </section>
    <!-- Pied de page -->
    <footer>
        <?php include_once('class/class.footer.php'); ?>
    </footer>
</body>
</html>
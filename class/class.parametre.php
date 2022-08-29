<?php
include('class.fonction.php');
include('conf.php');
session_start();
if($_SESSION['username'] == "")
{
    header('Location: /login.php');
}

if (isset($_POST['edit']))
{
    if (isset($_POST['id_user'],$_POST['username'], $_POST['email'], $_POST['type']))
    {
        if(isset($_POST['etat']))
        {
            $username_id = stripslashes($_POST['id_user']);
            $username_id = mysqli_real_escape_string($conn, $username_id);
            $username = stripslashes($_POST['username']);
            $username = mysqli_real_escape_string($conn, $username);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($conn, $email);
            $type = stripslashes($_POST['type']);
            $type = mysqli_real_escape_string($conn, $type);
            $etat = 'true';
            $query="UPDATE `users` SET `username`='$username',`email`='$email',`type`='$type', `etat`='$etat' WHERE `id`='$username_id'";
            mysqli_query($conn,$query);
            $date = date('j-m-y H-i-s');
            $IP = $_SERVER['REMOTE_ADDR'];
            $user = $_SESSION['username'];
            $log = "[$date] Activation de l'utilisateur $username par $user via l'adresse IP $IP \n";
            $fichierLog = "../logs/user.log"; 
            error_log($log, 3, $fichierLog);
            header('Location: /parametre.php?update=update_1');
        }
        else
        {
            $username_id = stripslashes($_POST['id_user']);
            $username_id = mysqli_real_escape_string($conn, $username_id);
            $username = stripslashes($_POST['username']);
            $username = mysqli_real_escape_string($conn, $username);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($conn, $email);
            $type = stripslashes($_POST['type']);
            $type = mysqli_real_escape_string($conn, $type);
            $etat = 'false';
            $query="UPDATE `users` SET `username`='$username',`email`='$email',`type`='$type', `etat`='$etat' WHERE `id`='$username_id'";
            mysqli_query($conn,$query);
            $date = date('j-m-y H-i-s');
            $IP = $_SERVER['REMOTE_ADDR'];
            $user = $_SESSION['username'];
            $log = "[$date] Desactivation de l'utilisateur $username par $user via l'adresse IP $IP \n";
            $fichierLog = "../logs/user.log"; 
            error_log($log, 3, $fichierLog);
            header('Location: /parametre.php?update=update_1');
        }

    }
}

if (isset($_POST['delete']))
{
    if (isset($_POST['id_user']))
    {
        $username = stripslashes($_POST['username']);;
        $username = mysqli_real_escape_string($conn, $username);;
        $username_id = stripslashes($_POST['id_user']);
        $username_id = mysqli_real_escape_string($conn, $username_id);
        $query="DELETE FROM `users` WHERE `id`=$username_id";
        mysqli_query($conn,$query);
        $date = date('j-m-y H-i-s');
        $IP = $_SERVER['REMOTE_ADDR'];
        $user = $_SESSION['username'];
        $log = "[$date] Suppression de l'utilisateur $username par $user via l'adresse IP $IP \n";
        $fichierLog = "../logs/user.log"; 
        error_log($log, 3, $fichierLog);
        header('Location: /parametre.php?delete=delete_1');
    }
}
if (isset($_POST['deleteno']))
{
    header('Location: /parametre.php');
}
if (isset($_POST['update_smtp']))
{
    if (isset($_POST['serveur'], $_POST['utilisateur'], $_POST['mot-de-passe'], $_POST['email'], $_POST['nom'], $_POST['prefixe'], $_POST['mail_debug']))
    {
        $host = stripslashes($_POST['serveur']);
        $host = mysqli_real_escape_string($conn, $host);
        $user = stripslashes($_POST['utilisateur']);
        $user = mysqli_real_escape_string($conn, $user);
        $password = stripslashes($_POST['mot-de-passe']);
        $password = mysqli_real_escape_string($conn, $password);
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($conn, $email);
        $username = stripslashes($_POST['nom']);
        $username = mysqli_real_escape_string($conn, $username);
        $prefixe = stripslashes($_POST['prefixe']);
        $prefixe = mysqli_real_escape_string($conn, $prefixe);
        $mail_debug = stripslashes($_POST['mail_debug']);
        $mail_debug = mysqli_real_escape_string($conn, $mail_debug);
        $query="UPDATE `mail` SET `host`='$host',`user`='$user',`password`='$password', `email`='$email', `username`='$username', `prefixe`='$prefixe', `mail_debug`='$mail_debug'  WHERE `id`='1'";
        mysqli_query($conn,$query);
        header('Location: /parametre.php?update_mail=1');

    }   
}

if (isset($_POST['test_smtp']))
{
    include('class.envoie_mail.php'); 
    $bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
    $query = "SELECT * FROM mail"; 
    $pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
    $result = mysqli_query($conn,$query);
    if ($row = mysqli_fetch_array($result))
    {
        $dest = htmlspecialchars($row['mail_debug']);
        $objet = "Message de test ";
        $contenu = "Ceci est un message de test";
        sendmail($objet, $contenu, $dest);
        header('Location: /parametre.php?mail=1');
    }
}
    
if (isset($_POST['update_conf_server']))
{
    if (isset($_POST['duree']))
    {
        $duree = $_POST['duree'];
        $query = "UPDATE `parametre_serveur` SET `duree_session`=$duree";
        mysqli_query($conn, $query);
        header('Location: /parametre.php?update_para_serveur=1');
    }
}

if (isset($_POST['update_logo']))
{
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
    {
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['logo']['size'] <= 1000000)
        {
                // Testons si l'extension est autorisée
                $fileInfo = pathinfo($_FILES['logo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $fichier="Logo.png";
                //suppression du fichier logo présent sur le serveur
                unlink('../img/Logo.png');
                if (in_array($extension, $allowedExtensions))
                {
                        // On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($_FILES['logo']['tmp_name'], '../img/' . $fichier);
                        header('Location: /parametre.php?update_logo=1');
                }
        }
    }
    

}

?>
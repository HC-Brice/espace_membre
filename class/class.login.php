<?php
//fonction pour le login de l'utilisateur
session_start();
if(!isset($_POST['fonction']) == 'login')
{
    require('conf.php');
    //On vérifie d'abord le captcha
    if(isset($_POST["captcha"]) && $_POST["captcha"]!="" && $_SESSION["code"]==$_POST["captcha"])
    {
        if (isset($_POST['username']) && isset($_POST['password']))
        {
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($conn, $username);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($conn, $password);
            $query = "SELECT * FROM `users` WHERE username='$username' and password='".hash('sha256', $password)."'";
            $result = mysqli_query($conn,$query) or die(mysql_error());
            $etat_user = $result->fetch_fields();
                if (mysqli_num_rows($result) == 1)
                {
                    $user = mysqli_fetch_assoc($result);
                    $etat = $user['etat'];
                    if($etat=='true')
                    {
                        $_SESSION['username'] = $username;
                        $dateConn=date('d/m/Y H:i');
                        $query= "UPDATE users SET `dernière connection`='$dateConn' WHERE username='$username'";
                        $result = mysqli_query($conn,$query);
                        session_start();
                        $user = $_SESSION['username'];
                        $date = date('j-m-y H-i-s');
                        $IP = $_SERVER['REMOTE_ADDR'];
                        $log = "[$date] Connection de l'utilisateur $user via l'adresse IP $IP \n";
                        $fichierLog = "../logs/connection.log"; 
                        error_log($log, 3, $fichierLog);
                        header('location: /index.php');
                    }
                    else
                    {
                        header('location: /login.php?user=error_1');
                    }
                    
  
                }
                else
                {
                    $date = date('j-m-y H-i-s');
                    $IP = $_SERVER['REMOTE_ADDR'];
                    $log = "[$date] Tentative de connection avec l'utilisateur $username via l'adresse IP $IP \n";
                    $fichierLog = "../logs/erreur-login.log"; 
                    error_log($log, 3, $fichierLog);
                    header('location: /login.php?login=error_1');
                }
        }
    }
    else
    {
        $date = date('j-m-y H-i-s');
        $IP = $_SERVER['REMOTE_ADDR'];
        $log = "[$date] Erreur de captcha via l'adresse IP $IP \n";
        $fichierLog = "../logs/erreur-login.log"; 
        error_log($log, 3, $fichierLog);
        header('location: /login.php?code_securite=error_1');
    }

}
else
{
    header('location: /login.php');
}
?>
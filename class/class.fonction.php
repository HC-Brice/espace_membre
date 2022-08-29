<?php
session_start();
//Définir si le fichier de configuration existe
$file="class/conf.php";
if(!file_exists($file))
{
    header('Location: /install.php');
}

//Définir si un user est admin ou non
function user_is_admin()
{
    require('conf.php');
    $username = $_SESSION['username'];
    if (isset($username))
    {
        $query = "SELECT * FROM `users` WHERE username='$username' ";
        $result = mysqli_query($conn,$query) or die(mysql_error());
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if ($user['type'] == 'admin')
            {
                return 'administrateur';
            }
            else
            {
                return 'user';
            }
        }
    }
}
//Définir si un user est admin ou non
function user_is_actif()
{
    require('conf.php');
    $username = $_SESSION['username'];
    if (isset($username))
    {
        $query = "SELECT * FROM `users` WHERE username='$username' ";
        $result = mysqli_query($conn,$query) or die(mysql_error());
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if ($user['etat'] == 'true')
            {
                return 'true';
            }
            else
            {
                return 'false';
            }
        }
    }
}
function etatSession()
{
    include('class/conf.php');
    $bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
    $query = "SELECT duree_session FROM parametre_serveur"; 
    $pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $dureeSession = $row['duree_session'];
    if(isset($_SESSION['temps']))
    {
        $_SESSION['limite'] = $dureeSession;
        if(time()>($_SESSION['limite'] + $_SESSION['temps']))
        {
            session_destroy(); 
        }
        else
        {
            $_SESSION['temps'] = time();
        }
    }
    else
    {
        $_SESSION['limite'] = $dureeSession;
        $_SESSION['temps'] = time();
    }
}
?>
<?php
include('class.fonction.php');
include('conf.php');
session_start();
if($_SESSION['username'] == "")
{
    header('Location: /login.php');
}
$bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
$user = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$user'"; 
$pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
$result = mysqli_query($conn,$query);
if($row = mysqli_fetch_array($result))
{
    $password_actuel = $row['password'];
    
}

if (isset($_POST['username'], $_POST['email'], $_POST['password']))
{
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($conn, $username); 
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    if($password_actuel!=$password)
    {
        if(isset($_POST['mode_sombre']))
        {
            $mode_sombre = stripslashes($_POST['mode_sombre']);
            $mode_sombre = mysqli_real_escape_string($conn, $mode_sombre);
            $query = "UPDATE `users` SET `username`='$username',`email`='$email',`password`='".hash('sha256', $password)."',`mode sombre`='true' WHERE `username`='$user'";
            $res = mysqli_query($conn, $query);
            $_SESSION['username']=$username;
            if($res){
                header('Location: /compte.php?update=1');
            }
        }
        else
        {
            $mode_sombre = stripslashes($_POST['mode_sombre']);
            $mode_sombre = mysqli_real_escape_string($conn, $mode_sombre);
            $query = "UPDATE `users` SET `username`='$username',`email`='$email',`password`='".hash('sha256', $password)."',`mode sombre`='false' WHERE `username`='$user'";
            $res = mysqli_query($conn, $query);
            $_SESSION['username']=$username;
            if($res){
                header('Location: /compte.php?update=1');
            }
        }
    }
    else
    {
        if(isset($_POST['mode_sombre']))
        {
            $mode_sombre = stripslashes($_POST['mode_sombre']);
            $mode_sombre = mysqli_real_escape_string($conn, $mode_sombre);
            $query = "UPDATE `users` SET `username`='$username',`email`='$email',`mode sombre`='true' WHERE `username`='$user'";
            $res = mysqli_query($conn, $query);
            $_SESSION['username']=$username;
            if($res){
                header('Location: /compte.php?update=1');
            }
        }
        else
        {
            $mode_sombre = stripslashes($_POST['mode_sombre']);
            $mode_sombre = mysqli_real_escape_string($conn, $mode_sombre);
            $query = "UPDATE `users` SET `username`='$username',`email`='$email',`mode sombre`='false' WHERE `username`='$user'";
            $res = mysqli_query($conn, $query);
            $_SESSION['username']=$username;
            if($res){
                header('Location: /compte.php?update=1');
            }
        }
    }

}


?>
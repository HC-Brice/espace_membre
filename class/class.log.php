<?php
include('class.fonction.php');
include('conf.php');
session_start();
if($_SESSION['username'] == "")
{
    header('Location: /login.php');
}

$log = $_GET['log'];
if(!empty($log))
{
    file_put_contents("../logs/$log.log",'');
    header("Location: ../log.php?log=$log");
}
?>
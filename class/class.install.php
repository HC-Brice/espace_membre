<?php
include('class.fonction.php');
include('conf.php');
session_start();
if (isset($_POST['serveur'], $_POST['user'], $_POST['password'],$_POST['table']))
{
    $serveur=$_POST['serveur'];
    $user=$_POST['user'];
    $password=$_POST['password'];
    $table=$_POST['table'];
    //name of file conf
    $nameFile = "conf.php";
    //ligne of file
    $varPHP='<?php';
    $varServeur= '$DB_SERVER';
    $varUser= '$DB_USERNAME';
    $varPassword= '$DB_PASSWORD';
    $varTable= '$DB_NAME';
    $varConn='$conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);';
    $confL1=$varPHP;
    $confL2="\r\n"."//Fichier de configuration";
    $confL3="\r\n"."$varServeur='".$serveur."';";
    $confL4="\r\n"."$varUser='".$user."';";
    $confL5="\r\n"."$varPassword='".$password."';";
    $confL6="\r\n"."$varTable='".$table."';";
    $confL7="\r\n"."// Connexion à la base de données MySQL";
    $confL8="\r\n"."$varConn";
    $confL9="\r\n"."?>";
    //remove ligne of file conf.php
    file_put_contents($nameFile, '');
    //open file and write on the last ligne
    $confFile = fopen($nameFile, "a");
    fwrite($confFile, $confL1);
    fwrite($confFile, $confL2);
    fwrite($confFile, $confL3);
    fwrite($confFile, $confL4);
    fwrite($confFile, $confL5);
    fwrite($confFile, $confL6);
    fwrite($confFile, $confL7);
    fwrite($confFile, $confL8);
    fwrite($confFile, $confL9);
    //close file
    fclose($confFile);
    //creation BDD
    try
    {
        $dbco=new PDO("mysql:host=$serveur", $user, $password);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql="CREATE DATABASE IF NOT EXISTS $table";
        $dbco->exec($sql);
    }
    catch(PDOException $e)
    {
        echo "Erreur : " . $e->getMessage();
    }
    //include file conf
    include('conf.php');
    //creation table mail
    $query="CREATE TABLE `mail` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `host` VARCHAR(50) NOT NULL , `user` VARCHAR(50) NOT NULL , `password` VARCHAR(50) NOT NULL , `email` VARCHAR(50) NOT NULL , `username` VARCHAR(50) NOT NULL , `prefixe` VARCHAR(50) NOT NULL , `mail_debug` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; ";
    mysqli_query($conn,$query);
    //creation table parametre_serveur
    $query="CREATE TABLE `parametre_serveur` ( `duree_session` DECIMAL(10,0) NOT NULL ) ENGINE = InnoDB; ";
    mysqli_query($conn,$query);
    //creation table recup_mdp
    $query="CREATE TABLE `recup_mdp` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `code` CHAR(32) NOT NULL , `mail` VARCHAR(50) NOT NULL , `date` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; ";
    mysqli_query($conn,$query);
    //creation table users
    $query="CREATE TABLE `users` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `username` VARCHAR(100) NOT NULL , `email` VARCHAR(100) NOT NULL , `type` VARCHAR(100) NOT NULL , `password` VARCHAR(100) NOT NULL , `etat` TEXT NOT NULL , `dernière connection` VARCHAR(50) NOT NULL , `mode sombre` VARCHAR(10) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; ";
    mysqli_query($conn,$query);
    //creation of an administrator account
    $query="INSERT into `users` (`username`, `email`, `type`, `password`, `etat`,`dernière connection`, `mode sombre`)VALUES ('admin', '', 'admin', '".hash('sha256', 'admin')."','true', '', 'false')";
    mysqli_query($conn,$query);
    //creation of an user account
    $query="INSERT into `users` (`username`, `email`, `type`, `password`, `etat`,`dernière connection`, `mode sombre`)VALUES ('user', '', 'user', '".hash('sha256', 'user')."','true', '', 'false')";
    mysqli_query($conn,$query);
    //PHP session parameter creation
    $query="INSERT into `parametre_serveur` (`duree_session`) VALUES ('900')";
    mysqli_query($conn,$query);
    //creation data mail
    $query="INSERT INTO `mail` SET `host`='',`user`='',`password`='', `email`='', `username`='', `prefixe`='', `mail_debug`=''";
    mysqli_query($conn,$query);
    header("Location: /login.php?install=install_1");
}
?>
<?php
include_once('fonction.php');
if(user_is_admin() !== 'administrateur')
{
    header('Location: index.php');
}
if(!isset($_POST['fonction']) == 'inscription')
{
    require('conf.php');
	include('envoie_mail.php');
    if (isset($_POST['username'], $_POST['email'], $_POST['password'],$_POST['type'])){
    	$username = stripslashes($_POST['username']);
    	$username = mysqli_real_escape_string($conn, $username); 
    	$email = stripslashes($_POST['email']);
    	$email = mysqli_real_escape_string($conn, $email);
    	$password = stripslashes($_POST['password']);
    	$password = mysqli_real_escape_string($conn, $password);
    	$type = stripslashes($_POST['type']);
    	$type = mysqli_real_escape_string($conn, $type);
	    $query = "INSERT into `users` (`username`, `email`, `type`, `password`, `etat`,`dernière connection`, `mode sombre`)
			VALUES ('$username', '$email', '$type', '".hash('sha256', $password)."','true', '', 'false')";
	    $res = mysqli_query($conn, $query);
		$dest = $email;
		$objet = "Bienvenue sur l'interface HC-Domotique";
		$contenu = "Validation de votre inscription. Voici vos identifiants :<br><b>Nom d'utilisateur : </b>$username<br><b>Mot de passe : </b>$password<br>Il est vivement recommander de modifier ce nouveau mot de passe depuis votre espace membre !";
		sendmail($objet, $contenu, $dest);
        if($res){
			$date = date('j-m-y H-i-s');
			$IP = $_SERVER['REMOTE_ADDR'];
			$user = $_SESSION['username'];
			$log = "[$date] Ajout de l'utilisateur $username par $user via l'adresse IP $IP \n";
			$fichierLog = "../logs/user.log"; 
			error_log($log, 3, $fichierLog);
            header("Location: /parametre.php?inscription=1&user=$username&password=$password&type=$type");
        }
    }
}
?>
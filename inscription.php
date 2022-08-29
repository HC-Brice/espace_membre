<?php
session_start();
include_once('class/class.fonction.php');
if(user_is_admin() !== 'administrateur')
{
    header('Location: index.php');
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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
	<title>Inscription</title>
    <?php
	session_start();
	include('class/conf.php');
	$bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
	$query = "SELECT * FROM users"; 
	$pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
	$result = mysqli_query($conn,$query);
	if ($row = mysqli_fetch_array($result))
	{
	    $mode_affichage = $row['mode sombre'];
	    if($mode_affichage=='true')
	    {
        	?>
        	<link rel="stylesheet" href="/css/style_sombre.css"/>
        	<?php
    	}
    	else
    	{
	        ?>
        	<link rel="stylesheet" href="/css/style_clair.css"/>
        	<?php
    	}
	}
    ?>
</head>
<body>
	<div id="container">
		<form action="class/class.inscription.php" method="post" name="inscription">
			<img style="width: 20%;display: block;margin: 0px auto;" src="/img/Logo.png"></img>
			<h1 style="margin-left:5%;">S'inscrire</h1>
			<input style="margin-left:5%;" type="text" class="input_login" name="username" placeholder="Nom d'utilisateur" required />
			<input style="margin-left:5%;" type="email" style="margin-top:20px" class="input_login" name="email" placeholder="Email" required />
			<input style="margin-left:5%;" type="password" style="margin-top:20px" class="input_login" name="password" placeholder="Mot de passe" required />
			<br/>
			<select style="margin-left:5%;" name="type" style="margin-top:20px" class="input_login" required>
				<option value="admin">Administrateur</option>
				<option value="user">Utilisateur</option>
			</select>
			<input type="submit" style="margin-top:20px" name="submit" value="S'inscrire" class="btn-login"/>
			<a href="parametre.php">Retour à la page de configuration des utilisateurs</a>
		</form>
	</div>
</body>
</html>
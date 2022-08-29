<?php
session_start();
if($_SESSION['username'] != "")
{
    header('Location: index.php');
}
include('class/class.fonction.php')
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
	<link rel="shortcut icon" type="image/png" href="img/Logo.png" />
	<link rel="stylesheet" href="/css/style_clair.css"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
</head>
<body>
	<div id="container">
		<form action="class/class.login.php" method="post" name="login">
			<a href="/index.php"><img style="width: 150px;display: block;margin: 0px auto;" src="/img/Logo.png"></img></a>
			<h1 style="margin-left:5%;">Connexion</h1>
			<div style="">
				<i id="icone" class="fa fa-user"></i>
				<input type="text" class="input_login" name="username" placeholder="Identifiant" required>
			</div>
			<div style="">
				<i id="icone" class="fa fa-key"></i>
				<input type="password" class="input_login" name="password" placeholder="Mot de passe" required>
			</div>
			<div style="">
				<i id="icone" class="fa fa-unlock"></i>
				<input name="captcha" class="input_login" type="text" placeholder="Code sécurité">
			<img src="/class/captcha.php" style="border: 1px solid #DDDDDD;vertical-align: middle;" width="80" height="28"/>
			</div>
			<input type="submit" value="Connexion " name="submit" class="btn-login">
			<a href=/mot-de-passe-oublie.php>Mot de passe oublié ?</a>
			<?php
				if(isset($_GET))
				{
					if(isset($_GET['login']) == 'error_1')
					{
						?>
						<p class="erreur">Identifiant ou mot de passe incorrect !</p>
						<?php
					}
					if(isset($_GET['code_securite']) == 'error_1')
					{
						?>
						<p class="erreur">Mauvaise valeur saisie pour le code de sécurité !</p>
						<?php
					}
					if(isset($_GET['deconnexion']) == '1')
					{
						?>
						<p class="validation">Vous êtes déconnecté !</p>
						<?php
					}
					if(isset($_GET['user']) == 'error_1')
					{
						?>
						<p class="erreur">Votre compte n'est pas actif, veuillez contacter un administrateur système !</p>
						<?php
					}
					if(isset($_GET['install']) == 'install_1')
					{
						?>
						<p class="validation">Votre système est prêt ! Identifiant = admin/admin </p>
						<?php
					}
				}
			?>
		</form>
	</div>
</body>
</html>
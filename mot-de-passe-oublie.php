<!DOCTYPE HTML>
<html>
	<head>
    	<meta charset="UTF-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>Mot de passe oublié</title>
        <link rel="stylesheet" href="/css/style_clair.css"/>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
	</head>
    <body>
    	<div id="container">
		<form class="form-login" action="/class/class.mot-de-passe-oublie.php" method="post">
		<a href="/index.php"><img style="width: 20%;display: block;margin: 0px auto;" src="/img/Logo.png"></img></a>
		<h1>Récupération du mot de passe</h1>
		<div style="">
			<i id="icone" class="fa fa-envelope"></i>
			<input type="email" name="mail" class="input_login" placeholder="Adresse mail" required>
		</div>
		<div style="">
			<i id="icone" class="fa fa-unlock"></i>
        	<input name="captcha" class="input_login" style="width:150px;" type="text" placeholder="Code sécurité">
        	<img src="/class/class.captcha.php" style="border: 1px solid #DDDDDD;vertical-align: middle;" width="80" height="28"/>
		</div>
		<input type="submit" name="valider" value="Régénérer et envoyer mot de passe" name="" class="btn-login">
		<?php
			if(isset($_GET))
			{
				if(isset($_GET['recup']) == '1')
				{
					?>
    				<p class="validation">Si cet identifiant est un compte valide, un e-mail de ré-initialisation du mot de passe vous a été envoyé.</p>
					<?php
				}
				if(isset($_GET['pass']) == '1')
				{
					?>
    				<p class="validation">Un nouveau mot de passe vient de vous être envoyé par mail.</p>
					<?php
				}
                if(isset($_GET['code_securite']) == 'error_1')
				{
					?>
    				<p class="erreur">Mauvaise valeur saisie pour le code de sécurité !</p>
					<?php
				}
			}
		?>
		</form>
    </body>
</html>
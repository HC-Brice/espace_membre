<?php
include('class.fonction.php');
include('conf.php');
session_start();
if($_SESSION['username'] == "")
{
    header('Location: /login.php');
}

$bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
$query = "SELECT duree_session FROM parametre_serveur"; 
$pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);
$dureeSession = $row['duree_session'];
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="<?php echo $dureeSession+2;?>;URL=/">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.min.css">
	<link rel="shortcut icon" type="image/png" href="img/Logo.png" />
    <?php
	session_start();
	$bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
	$username=$_SESSION['username'];
	$query = "SELECT * FROM `users` WHERE `username`='$username'"; 
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
    <header>
        <nav>
            <input type="checkbox" id="drop-menu">
            <label for="drop-menu" class="toggle-menu">
                <div class="hamburger-lines">
                    <span class="line line-top"></span>
                    <span class="line line-middle"></span>
                    <span class="line line-bottom"></span>
                </div>
            </label>
            
            <ul class="menu">
                <li class="li-level1"><a href="index.php"><i class='fas fa-home'></i>Accueil</a></li>
                <li class="li-level1"><a href="#"><i class="fas fa-home"></i>Lien 2 ▾</a>
                    <ul class="ul-level2">
                        <li class="li-level2"><a href="#"><i class="fas fa-home"></i>Sous-lien 1</a></li>
                        <li class="li-level2"><a href="#"><i class="fas fa-home"></i>Sous-lien 2</a></li>
                        <li class="li-level2"><a href="#"><i class="fas fa-home"></i>Sous-lien 3</a></li>
                    </ul>
                </li>
                <li class="li-level1"><a href="#"><i class="fas fa-home"></i>Lien 3 ▾</a>
                    <ul class="ul-level2">
                    <?php
				    if(user_is_admin()== 'administrateur')
				    {?>
                        <li class="li-level2"><a href="#"><i class="fas fa-home"></i>Sous-lien 1</a></li>
                    <?php
				    }
				    ?>
                        <li class="li-level2"><a href="#"><i class="fas fa-home"></i></i>Sous-lien 2</a></li>
                    </ul>
                </li>
                <?php
				if(user_is_admin()== 'administrateur')
				{?>
                <li class="li-level1"><a href="#"><i class='fas fa-stethoscope'></i>Analyse / Log ▾</a>
                    <ul class="ul-level2">
                        <li class="li-level2"><a href="/log.php?log=connection"><i class="fa-solid fa-user-lock"></i>Connection</a></li>
                        <li class="li-level2"><a href="/log.php?log=erreur-login"><i class="fa-solid fa-triangle-exclamation"></i>Login</a></li>
                        <li class="li-level2"><a href="/log.php?log=user"><i class="fas fa-users"></i>User</a></li>    
                    </ul>
                </li>
                <?php
				}
				?>
                <li class="li-level1"><a href="#"><i class='fas fa-wrench'></i>Réglages ▾</a>
                    <ul class="ul-level2">
                        <li class="li-level2"><a href="/compte.php"><i class='fas fa-users'></i>Mon compte</a></li>
                        <?php
					    if(user_is_admin()== 'administrateur')
					    {?>
						    <li class="li-level2"><a href="/parametre.php"><i class="fas fa-cog"></i>Paramètres</a></li>
					    <?php
					    }
					    ?>
                        <li class="li-level2"><a href="/logout.php"><i class="fas fa-sign-out-alt"></i>Se deconnecter</a></li>
                        <li class="li-level2"><a><i class="fas fa-info-circle"></i>
					    <?php
					    session_start();
					    print $_SESSION['username'];
					    ?></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
	<div style="margin-bottom:70px;"></div>
</body>
</html>
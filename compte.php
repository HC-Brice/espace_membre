<?php
session_start();
include_once('class/class.header.php');
if($_SESSION['username'] == "")
{
    header('Location: /login.php');
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
    <title>Mon compte</title>
</head>
<body>
    <section class="section">
        <section id="tuile">
            <h1>Mes informations</h1>
            <?php
            $bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM users WHERE username='$username' "; 
            $pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
            $stmt = $pdo->query($sql); 
            ?>
            <form action="class/class.compte.php" method="post" name="update_user">
            <div>
            <table>
            <thead>
            <tr>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                <th class="txt" style="padding:5px 10px 0px 0px;text-align:right;font-weight:bold">User :</th>
                <td><input type="text" name="username" class="userAttri" style="min-width:400px" class="userAttri" value="<?php echo htmlspecialchars($row['username']); ?>"></td>
            </tr>  
            <tr>
                <th class="txt" style="padding:5px 10px 0px 0px;text-align:right;font-weight:bold">Email :</th>
                <td><input type="text" name="email" class="userAttri" style="min-width:400px" class="userAttri" value="<?php echo htmlspecialchars($row['email']); ?>"></td>
            </tr>  
            <tr>
                <th class="txt" style="padding:5px 10px 0px 0px;text-align:right;;font-weight:bold">Mot de passe :</th>
                <td>
                    <input id="motdepasse" type="password" name="password" class="userAttri" style="min-width:400px" class="userAttri" value="<?php echo $row['password']; ?>">
                    <label class="custom-checkbox">
                        <input type="checkbox" onclick="Afficher()"/>
                        <i style="position:relative;left:-15px;top:7px;color:var(--color-texte_info);font-size:30px;" class="icon-eye-close unchecked"></i>
                        <i style="position:relative;left:-15px;top:7px;color:var(--color-texte_info);font-size:30px;" class="icon-eye-open checked"></i>
                    </label>
                </td>
                <script>
                function Afficher()
                { 
                var input = document.getElementById("motdepasse"); 
                if (input.type === "password")
                { 
                input.type = "text"; 
                } 
                else
                { 
                input.type = "password"; 
                } 
                } 
                </script>
            </tr>
            <tr>
                <th class="txt" style="padding:5px 10px 0px 0px;text-align:right;font-weight:bold">Date de dernière connection :</th>
                <td><div class="userAttri" style="min-width:400px" ><?php echo htmlspecialchars($row['dernière connection']); ?></div></td>
            </tr>
            <tr>
                <th class="txt" style="padding:5px 10px 0px 0px;text-align:right;font-weight:bold">Mode sombre :</th>
                <td>
                <?php
                $mode_sombre = htmlspecialchars($row['mode sombre']);
                if($mode_sombre=="true")
                {
                    echo '<input style="margin-left:0px" class="userAttri" type="checkbox" name="mode_sombre" checked>';
                }
                else
                {
                    echo '<input style="margin-left:0px" class="userAttri" type="checkbox" name="mode_sombre">';
                }
                ?>
                </td>
            </tr>
            </thead>
            <tbody>
            <?php endwhile; ?>
            </tbody>
            </table>
            </div>
            <input style="position:relative;margin-left:20px;margin-top:20px;margin-bottom:20px;"type="submit" value="Enregistrer " name="submit" class="btn">
            
            <?php
	        if(isset($_GET))
	        {
    		    if(isset($_GET['update']) == '1')
		        {
    			    ?>
    		        <p class="validation">Informations mise à jour !</p>
			        <?php
		        }

	        }
            ?>
            </form>
        </section>
    </section>
    <!-- Pied de page -->
    <footer>
        <?php include_once('class/class.footer.php'); ?>
    </footer>
</body>
</html>
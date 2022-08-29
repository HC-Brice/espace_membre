<?php
session_start();
include_once('class/class.header.php');

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
    <title>Paramètre</title>    
</head>
<body>
    <div class="tuile-reponsive">
        <section class="section">
        <div class="tabs">
            <span data-tab-value="#tab_1">Utilisateur</span>
            <span data-tab-value="#tab_2">Serveur mail</span>
            <span data-tab-value="#tab_3">Serveur</span>
            <span data-tab-value="#tab_4">Personnalisation</span>
        </div>
    
        <div class="tab-content">
            <div class="tabs__tab active" id="tab_1" data-tab-info>
            <section class="section_onglet">
                <?php
                $user_co=$_SESSION['username'];
                $bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
                $user_co = $_SESSION['username'];
                $sql = "SELECT * FROM users WHERE `username`!='$user_co'"; 
                $pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
                $stmt = $pdo->query($sql); 
                ?>
                <div>
                <table cellspacing="0" style="margin-left:-80px;margin-right:20px;">
                <thead>
                <tr>
                    <th class="tr_border" style="text-align:center;font-weight:bold;visibility:hidden;">ID</th>
                    <th class="tr_border">Etat</th>
                    <th class="tr_border">Username</th>
                    <th class="tr_border">Email</th>
                    <th class="tr_border">Type de compte</th>
                    <th class="tr_border">Dernière connection</th>
                    <th class="tr_border"></th>
                    <th class="tr_border"></th>
                </tr>
                </thead>
                <tbody>
                    <tr>   
                        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                        $id_user = htmlspecialchars($row['id']);
                        $user = htmlspecialchars($row['username']);
                        $email = htmlspecialchars($row['email']);
                        $type = htmlspecialchars($row['type']);
                        $etat = htmlspecialchars($row['etat']);
                        $dateConn = htmlspecialchars($row['dernière connection']);
                        ?>
                        <form action="/class/class.parametre.php" method="post" name="edit">
                            <td style="visibility:hidden;" class="td_border"><input type="text" name="id_user" style="margin-left:20px;cursor: not-allowed;width:60px;" class="userAttri" value="<?php echo $id_user; ?>"></td>
                            <td class="td_border">

                                <?php
                                    if($etat=="true")
                                    {
                                        echo '<input style="margin-left:20px;" class="userAttri" type="checkbox" name="etat" value="etat" checked>';
                                    }
                                    else
                                    {
                                        echo '<input style="margin-left:20px;" class="userAttri" type="checkbox" name="etat" value="etat">';
                                    }
                                    ?>

                            </td>
                            <td class="td_border"><input type="text" name="username" style="margin-left:20px;"class="userAttri" value="<?php echo $user; ?>"></td>
                            <td class="td_border"><input type="email" name="email" style="margin-left:20px;width:300px" class="userAttri" value="<?php echo $email; ?>"></td>
                            <td class="td_border">
                                <select class="userAttri" style="margin-left:20px;" name="type">
                                    <?php
                                    if($type=="admin")
                                    {
                                    ?>
                                        <option value="admin" selected>Administrateur</option>
                                        <option value="user">Utilisateur</option>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <option value="admin">Administrateur</option>
                                        <option value="user" selected>Utilisateur</option>
                                    <?php
                                    }
                                    ?>
                            </td>
                            <td class="td_border"><input type="text" name="dateConn" style="cursor: not-allowed;margin-left:20px;width:150px" class="userAttri" value="<?php echo $dateConn; ?>" disabled=""></td>
                            <td class="td_border">
                            <button name="edit" type="submit" style="font-size:20px;background-color:transparent;border-style : none;">
                                <i style="color:var(--color-texte_info);padding:0px 10px 0px 10px" class="fas fa-edit"></i>
                            </button>
                            </td>
                            <td class="td_border">
                                </form>
                                <button type="submit" style="font-size:20px;background-color:transparent;border-style : none;" onclick="location.href='?userid=<?php echo $id_user ?>&user=<?php echo $user ?>#modal-container';">
                                <i style="color:var(--color-texte_info);padding:0px 10px 0px 10px" class="fas fa-minus-circle pull-right cmdAction cursor"></i>
                                </button>
                                <main>
                                    <div id="modal-container">
                                        <div class="modal">
                                            <form action="/class/class.parametre.php" method="post" name="delete">
                                            <?php
                                            $id_user = $_GET['userid'];
                                            $user = $_GET['user'];
                                            ?>
                                            <h2>Veuillez confirmer</h2>
                                            <p>Êtes vous sûr de vouloir supprimer l'utilisateur <?php echo $user ?>?</p>
                                            <input type="text" name="id_user" style="width:0px;visibility:hidden;" value="<?php echo $id_user; ?>"> 
                                            <input type="text" name="username" style="width:0px;visibility:hidden;" value="<?php echo $user; ?>"> 
                                                <button name="delete" type="submit" class="modal-button modal-yes">Oui</button>
                                                <button name="deleteno"type="submit" class="modal-button modal-no">Non</button>
                                            </form>
                                        </div>
                                    </div>
                                </main>
                            </td>
                                    
                    </tr>
                        <?php endwhile; ?>
                </tbody>
                </table>
                </div>
                <a href="inscription.php">
                <input style="position:relative;margin-top:20px;margin-left:20px;margin-bottom:20px" type="submit" value="Nouvel utilisateur" name="user_add" class="btn">
                </a>
                
                <?php
                if(isset($_GET))
                {
                    if(isset($_GET['inscription']) == '1')
                    {
                        $user = $_GET['user'];
                        $type = $_GET['type'];
                        $password = $_GET['password'];
                        if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['type']))
                            ?>
                            <p class="validation"><?php echo "L'utililsateur $user a été rajouté avec un compte du type $type et le mot de passe $password;"?></p>
                            <?php
                    }
                    if(isset($_GET['update']) == 'update_1')
                    {
                        $user = $_GET['user'];
                        $type = $_GET['type'];
                        $password = $_GET['password'];
                        if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['type']))
                            ?>
                            <p class="validation"><?php echo "L'utililsateur a été mise à jour"?></p>
                            <?php
                    }
                    if(isset($_GET['delete']) == 'delete_1')
                    {
                        $user = $_GET['user'];
                        $type = $_GET['type'];
                        $password = $_GET['password'];
                        if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['type']))
                            ?>
                            <p class="validation"><?php echo "L'utililsateur a été supprimé"?></p>
                            <?php
                    }
                }
                ?>
            </section>
    
            </div>
            <div class="tabs__tab" id="tab_2" data-tab-info>
            <section class="section_onglet">
                <?php
                $bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
                $query = "SELECT * FROM mail"; 
                $pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
                $result = mysqli_query($conn,$query);
                if ($row = mysqli_fetch_array($result))
                {
                }
                ?>
                <div>
                <table style="margin-left:20px;">
                <tbody> 
                    <form action="/class/class.parametre.php" method="post" name="update_smtp">
                        <tr>
                            <td class="txt" style="font-weight:bold">Serveur</td>
                            <td><input type="text" name="serveur" style="width:400px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['host']); ?>"></td>
                        </tr>
                        <tr>    
                            <td class="txt" style="font-weight:bold">Utilisateur SMTP</td>
                            <td><input type="text" name="utilisateur" style="width:400px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['user']); ?>"></td>
                        </tr>
                        <tr>
                            <td class="txt" style="font-weight:bold">Mot de passe SMTP</td>
                            <td><input type="password" name="mot-de-passe" style="width:400px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['password']); ?>"></td>
                        </tr>
                        <tr>
                            <td class="txt" style="font-weight:bold">E-mail pour l'envoie</td>
                            <td><input type="text" name="email" style="width:400px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['email']); ?>"></td>
                        </tr>
                        <tr>
                            <td class="txt" style="font-weight:bold">Nom d'utilisateur</td>
                            <td><input type="text" name="nom" style="width:400px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['username']); ?>"></td>
                        </tr>
                        <tr>
                            <td class="txt" style="font-weight:bold">Préfixe des sujets</td>
                            <td><input type="text" name="prefixe" style="width:400px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['prefixe']); ?>"></td>
                        </tr>
                        <tr>
                            <td class="txt" style="font-weight:bold">Adresse mail de debug</td>
                            <td><span style="margin-left:20px;cursor: help" class="txt" title="Adresse utilisée pour l'envoie d'email de test"><i class="fas fa-info-circle"></i></span><input type="text" name="mail_debug" style="width:400px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['mail_debug']); ?>"></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                        <input style="position:relative;margin-left:20px;margin-top:20px;margin-bottom:20px" type="submit" value="Sauvegarder" name="update_smtp" class="btn">
                        <input style="position:relative;margin-left:20px;margin-top:20px;margin-bottom:20px" type="submit" value="Tester" name="test_smtp" class="btn">            
                    </form>
                    
                    <?php
                    if(isset($_GET))
                    {
                        if(isset($_GET['update_mail']) == '1')
                        {
                            $user = $_GET['user'];
                            $type = $_GET['type'];
                            $password = $_GET['password'];
                            if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['type']))
                                ?>
                                <p class="validation"><?php echo "Le compte mail a été mise à jour !"?></p>
                                <?php
                        }
                        if(isset($_GET['mail']) == '1')
                        {
                            ?>
                            <p class="validation"><?php echo "Un email de test vient d'être envoyé"?></p>
                            <?php
                        }
                    }
                ?>     
            </section>
    
            </div>
            <div class="tabs__tab" id="tab_3" data-tab-info>
            <section class="section_onglet">
            <?php
            $bd = "mysql:host=$DB_SERVER;dbname=$DB_NAME"; 
            $query = "SELECT duree_session FROM parametre_serveur"; 
            $pdo = new PDO($bd, $DB_USERNAME, $DB_PASSWORD);
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_array($result)
            ?>
            <div>
            <table style="margin-left:20px;">
                <tbody>
                <form action="/class/class.parametre.php" method="post" name="update_conf_server">
                    <tr>
                        <td class="txt" style="font-weight:bold">Durée de la session PHP</td>
                        <td><span style="margin-left:20px;cursor: help" class="txt" title="Durée en seconde avant déconnexion de l'utilisateur de sa session. Par exemple 900 signifie que si l'utilisateur ne charge pas de page pendant un lapse de temps de 15 minutes, il devra se reconnecter !"><i class="fas fa-info-circle"></i></span><input type="text" name="duree" style="width:100px;margin-left:20px" class="userAttri" value="<?php echo htmlspecialchars($row['duree_session']); ?>"></td>
                    </tr>
                </tbody>
                </table>
                </div>
                    <input style="position:relative;margin-left:20px;margin-top:20px;margin-bottom:20px" type="submit" value="Sauvegarder" name="update_conf_server" class="btn">
                </form>
                <?php
                    if(isset($_GET))
                    {
                        if(isset($_GET['update_para_serveur']) == '1')
                        {
                            ?>
                            <p class="validation"><?php echo "Paramètre serveur mise à jour !"?></p>
                            <?php
                        }
                    }
                ?>
            </section>
            </div>
            
            <div class="tabs__tab" id="tab_4" data-tab-info>
            <section class="section_onglet">
            <div>
                <form action="/class/class.parametre.php" method="POST" name="update_logo" enctype="multipart/form-data">
                <!-- Ajout champ d'upload ! -->
                <div class="mb-3">
                    <span style="margin-left:20px;cursor: help" class="txt" >Votre logo
                    <input type="file" class="form-control" name="logo" />
                </div>
                <!-- Fin ajout du champ -->
                <button style="position:relative;margin-left:20px;margin-top:20px;margin-bottom:20px" name="update_logo" type="submit" class="btn">Envoyer</button>
                </form>
            </div>
                <?php
                    if(isset($_GET))
                    {
                        if(isset($_GET['update_logo']) == '1')
                        {
                            ?>
                            <p class="validation"><?php echo "Logo mise à jour !"?></p>
                            <?php
                        }
                    }
                ?>
            </section>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        const tabs = document.querySelectorAll('[data-tab-value]')
        const tabInfos = document.querySelectorAll('[data-tab-info]')
  
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = document
                    .querySelector(tab.dataset.tabValue);
  
                tabInfos.forEach(tabInfo => {
                    tabInfo.classList.remove('active')
                })
                target.classList.add('active');
            })
        })
    </script>
    </section>
    <!-- Pied de page -->
    <footer>
        <?php include_once('class/class.footer.php'); ?>
    </footer>
</body>
</html>
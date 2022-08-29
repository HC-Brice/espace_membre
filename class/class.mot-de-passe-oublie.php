<?php
header('Content-Type: text/html; charset=utf-8');
include('envoie_mail.php');
include('conf.php');
session_start();
if(isset($_GET['code'],$_GET['mail']))
{
            //un lien est cliqué dans un mail, on recherche si le code et le mail correspondent à une ligne dans la table "recup_mdp"
            $code=htmlentities($_GET['code'],ENT_QUOTES,"UTF-8");
            $code=stripslashes($code);
            $code=mysqli_real_escape_string($conn, $code);
            $mail=htmlentities($_GET['mail'],ENT_QUOTES,"UTF-8");
            $mail=stripslashes($mail);
            $mail=mysqli_real_escape_string($conn, $mail);
            $query= "SELECT * FROM recup_mdp WHERE code='$code' AND mail='$mail'";
            echo $query;
            echo "<br>";
            $req=mysqli_query($conn,$query);
            if(mysqli_num_rows($req)==1)
            {
                $query = "SELECT * FROM recup_mdp WHERE code='$code' AND mail='$mail'";
                $result = mysqli_query($conn,$query);
                if ($row = mysqli_fetch_array($result))
                {
                    $date_reset = ($row['date']);
                    $date_actuel = time();
                    $difference_date = $date_actuel - $date_reset;
                    if($difference_date<300)
                    {
                        //on génère un nouveau pass (de 9 caractères) et on lui envoi:
                        $NouveauPass=substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"),0,9);
                        //on modifie son mot de passe pour son compte
                        $query= "UPDATE users SET password='".hash('sha256', $NouveauPass)."' WHERE email='$mail'";
                        $result = mysqli_query($conn,$query);
                        $query= "SELECT * from users WHERE email='$mail'";
                        $result = mysqli_query($conn,$query);
                        if ($row = mysqli_fetch_array($result))
                        {
                            $user = htmlspecialchars($row['username']);
                        }
                            
                        //on lui envoi un mail avec son password temporaire:
					    $dest = $mail;
					    $objet = "Vos nouveau identifiant";
					    $contenu = "Vos nouveaux identifiants pour vous connecter à l'application sont :<br><b>Nom d'utilisateur : </b>$user<br><b>Mot de passe : </b>$NouveauPass<br>Il est vivement recommander de modifier ce nouveau mot de passe depuis votre espace membre !";
					    sendmail($objet, $contenu, $dest);
                        //on supprime la demande mot de passe qui est dans la table "recup_mdp":
                        mysqli_query($mysqli,"DELETE FROM recup_mdp WHERE code='$code' AND mail='$mail'");
					    header('Location: /mot-de-passe-oublie.php?pass=1');
                    }
                    else
                    {
                        echo 'Lien expiré';
                    }
                }
            }
            else
            {
                echo "Lien incorrect.";
            }
}
        else
        {
            //si le formulaire est envoyé ("envoyé" signifie que le bouton submit est cliqué)
            if(isset($_POST['valider'])){
                    //On vérifie d'abord le captcha
                    if(isset($_POST["captcha"]) && $_POST["captcha"]!="" && $_SESSION["code"]==$_POST["captcha"])
                    {
                        //vérifie si le champ mail est bien rempli:
                        if(empty($_POST['mail']))
                        {
                            echo "Le champs mail n'est pas renseigné.";
                            }
                        else
                        {
                            //tous les champs sont précisés, on regarde si le membre est inscrit dans la bdd:
                            //d'abord il faut créer une connexion à la base de données dans laquelle on souhaite regarder:
                            $mysqli=mysqli_connect($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);
                            if(!$mysqli)
                            {
                                echo "Erreur connexion BDD";
                                //Dans ce script, je pars du principe que les erreurs ne sont pas affichées sur le site, vous pouvez donc voir qu'elle erreur est survenue avec mysqli_error(), pour cela décommentez la ligne suivante:
                        
                                //echo "<br>Erreur retournée: ".mysqli_error($mysqli);
                        
                            }
                            else
                            {
                                //on défini nos variables:
                                $mail=htmlentities($_POST['mail'],ENT_QUOTES,"UTF-8");//htmlentities avec ENT_QUOTES permet de sécuriser la requête pour éviter les injections SQL, UTF-8 pour dire de convertir en ce format
                                $req=mysqli_query($mysqli,"SELECT * FROM users WHERE email='$mail'");
                                //on regarde si le membre est inscrit dans la bdd:
                                //même si le membre n'existe pas, on affiche qu'un mail à été envoyé, ceci permet d'empécher les robots de voir si un mail existe ou pas dans votre base de données et de vous le dérober
                                if(mysqli_num_rows($req)!=1)
                                {
                                    //mail inconnu
                                }
                                else
                                {
                                    //mail connu, on lance la procédure d'envoi du mail pour recevoir un nouveau mdp
                                    header('Content-Type: text/html; charset=utf-8');
                                    $code=md5(rand(1,99999999));
                                    $date=  time();
                                    mysqli_query($mysqli,"INSERT INTO recup_mdp SET code='$code', mail='$mail', date='$date'");
                                    $adresse = "http://{$_SERVER['HTTP_HOST']}";
                                    $Lien= $adresse."/class/mot-de-passe-oublie.php?code=$code&mail=$mail";
							        $dest = $mail;
							        $objet = "Récupération du mot de passe";
							        $contenu = "Une requête pour changer de mot de passe a été reçue.<br>Veuillez confirmer que vous êtes bien à l'origine de cette demande en cliquant sur le lien suivant :<br><a href=$Lien>$Lien</a>.<br>Attention ce lien expire dans 5 minutes.<br>Si vous n'êtes pas à l'origine de cette demande, ignorez simplement ce message. Vos identifiants restent sécurisés.";
                                    echo $contenu;
							        sendmail($objet, $contenu, $dest);
                                }
                                header('Location: /mot-de-passe-oublie.php?recup=recup_1');
                            }
                        }
                    }
                    else
                    {
                        header('Location: /mot-de-passe-oublie.php?code_securite=error_1');
                    }
            }
        }
?>
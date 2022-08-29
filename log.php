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
    <title>Logs</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
</head>
<body>
<?php
$log = $_GET['log'];
if(!empty($log))
{
    if($log=="connection")
    {
        ?>
        <a class="btn_log" href="/class/class.log.php?log=connection"><i style="margin-right:5px;" class="far fa-trash-alt"></i>Vider log</a>
        <section class="log_prev">
        <div style="margin-left:5px;">
        <?php
        $lines = file('logs/connection.log');
        foreach($lines as $line_num => $line) {
        echo htmlspecialchars($line)."<br />\n";
        }
        ?>
        </div>
        </section>
        <?php
        
    }
    if($log=="erreur-login")
    {
        ?>
        <a class="btn_log" href="/class/class.log.php?log=erreur-login"><i style="margin-right:5px;" class="far fa-trash-alt"></i>Vider log</a>
        <section class="log_prev">
        <div style="margin-left:5px;">
        <?php
        $lines = file('logs/erreur-login.log');
        foreach($lines as $line_num => $line) {
        echo htmlspecialchars($line)."<br />\n";
        }
        ?>
        </div>
        </section>
        <?php  
    }
    if($log=="user")
    {
        ?>
        <a class="btn_log" href="/class/class.log.php?log=user"><i style="margin-right:5px;" class="far fa-trash-alt"></i>Vider log</a>
        <section class="log_prev">
        <div style="margin-left:5px;">
        <?php
        $lines = file('logs/user.log');
        foreach($lines as $line_num => $line) {
        echo htmlspecialchars($line)."<br />\n";
        }
        ?>
        </div>
        </section>
        <?php
    }
}
else
{
    echo 'Aucun log disponible';
}

?>
<!-- Pied de page -->
<footer>
    <?php include_once('class/class.footer.php'); ?>
</footer>
</body>
</html>
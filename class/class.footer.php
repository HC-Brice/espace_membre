<?php
include('conf.php');
session_start();
if($_SESSION['username'] == "")
{
    header('Location: /login.php');
}
?>
<html>
<head>

</head>
<body>
<div id="footer">
  <div id="footer_txt">Une création de<br><a style="color:var(--color-texte_info);font-size:25px;text-decoration:none;" href="www.hc-domotique.fr">HC-Domotique.fr</div>
  <img id="footer_img" src="/img/Logo.png"></img>
</div>
</body>
</html>
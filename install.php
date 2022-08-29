<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install</title>
	<link rel="shortcut icon" type="image/png" href="img/Logo.png" />
	<link rel="stylesheet" href="/css/style_clair.css"/>
</head>
<body>
    <section class="section">
        <section id="tuile">
            <h1>Configuration SQL</h1>
            <form action="/class/class.install.php" method="post">
                <table cellspacing="0" style="margin-left:20px;margin-right:20px;">
                <tbody>
                    <tr>
                        <td class="txt" style="font-weight:bold">Adresse du serveur SQL</td>
                        <td><input type="text" name="serveur" style="width:400px;margin-left:20px" class="userAttri"></td>
                    </tr>
                    <tr>
                        <td class="txt" style="font-weight:bold">User</td>
                        <td><input type="text" name="user" style="width:400px;margin-left:20px" class="userAttri"></td>
                    </tr>
                    <tr>
                        <td class="txt" style="font-weight:bold">Password</td>
                        <td><input type="password" name="password" style="width:400px;margin-left:20px" class="userAttri"></td>
                    </tr>
                    <tr>
                        <td class="txt" style="font-weight:bold">Table</td>
                        <td><input type="text" name="table" style="width:400px;margin-left:20px" class="userAttri"></td>
                    </tr>
                </tbody> 
                </table>
                <input type="submit" style="margin-top:20px" name="submit" value="Enregistrer" class="btn-login"/>
        </section>
    </section>
</body>
</html>

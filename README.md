# espace_membre
Ce site permet de créer un espace membre avec les fonctionnalitées suivantes :
- Page de login.
- Page de reinitialisation de mot de passe utilisateur.
- Esapce admin. (type de compte administrateur)
- Espace user. (type de compte utilisateur)
- Gestion des comptes utilisateurs.
- Gestion des paramètres serveurs.
- Envoie d'email (via PHPMailer)

Le contenu du site peut être ajouter sur les différentes pages selon le besoin.

Instruction d'installation:
Lors de la mise en place du site, vous serez en premier lieu redirigé vers la page /install.php.
![image](https://user-images.githubusercontent.com/110855142/187190529-5545df85-6d37-4084-8a1a-606ca9a1d0d4.png)
L'adresse du serveur MYSQL, le nom d'utilisateur, le mot de passe et le nom de la BDD est à renseigner sur cette page.
Une fois ces informations renseigné, le script d'installation installe toutes les tables utilent au site.
Vous pouvez à présent vous connecter à l'aide des identifiants par defaut (admin/admin ou user/user)

Page Analyse/Log:
![image](https://user-images.githubusercontent.com/110855142/187191777-176cf449-2b3c-4de9-a112-fed7f1011a55.png)
Page permettant de visualiser les logs du serveur.

Page de réglages :
Mon compte :
![image](https://user-images.githubusercontent.com/110855142/187191095-5df27bb2-44e9-4aa4-9db5-8b504e59658a.png)
Page accessible à toutes les utilisateurs (quelques soit le type de compte).
Cette page permet de modifier les informations de l'utilisateur (username, email, mot de passe (mot de passe hash), date de dernière connection, mode sombre (mode dark))

Paramètre :
![image](https://user-images.githubusercontent.com/110855142/187191371-ef548401-6969-44b4-b35b-4076841210ed.png)
Page est accessible uniquement au administrateur.
Cette page permet de modifier les paramètres suivant :
- Ajout/suppression/modifiation d'utilisateur.
- Paramètrage du serveur mail.
- Paramètrage du serveur.
- Personnalisation graphique du site.

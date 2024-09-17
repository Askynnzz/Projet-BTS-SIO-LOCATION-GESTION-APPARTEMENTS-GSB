<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/connexionStyle.css" rel="stylesheet">
</head>
    <title>Document</title>
</head>
<body>
<h1>Se connecter</h1>
    <form method="post" action="../Contrôleur/ConnexionController.php?action=connexion">

        <label>Login :</label>
        <input type="text" name="login" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="mdp" required><br>

        <input type="submit" name="action" value="Se connecter">
    </form>
</body>
</html>
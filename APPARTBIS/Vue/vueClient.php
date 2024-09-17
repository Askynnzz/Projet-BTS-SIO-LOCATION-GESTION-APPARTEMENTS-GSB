<?php
session_start();

// Inclure votre classe Rapport
include '../Modèle/db_config.php';
include '../Modèle/Appartement.php';


// Créer une instance de la classe Rapport avec la connexion à la base de données
$database = new Database();
$db = $database->getConnection();
$appart = new Appartement($db);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
   header("Location: vueConnexion.php");
   exit();
}

// Récupérer l'ID de l'utilisateur connecté
$idClient = $_SESSION['user_id'];

// Appeler la méthode pour récupérer la liste des rapports de l'utilisateur
$listeApparts = $appart->voirListeAppart();
 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/vueLocationStyle.css" rel="stylesheet">
    <title>Liste des Appartements</title>
    <style>
        .rapport-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<a href="vueDemandeClient.php">Mes demandes</a>
<!-- Bouton de déconnexion -->
<form method="post" action="../Contrôleur/DeconnexionController.php?action=deconnexion">
    <input type="submit" name="action" value="Se deconnecter">
</form>


    <h2>Liste des Appartements</h2>

    <?php
    if ($listeApparts) {
        foreach ($listeApparts as $appart) {
            echo '<a href="vueAppart.php?id=' . $appart['numappart'] . '" class="rapport-box">';
            echo '<p>ID : ' . $appart['numappart'] . '</p>';
            echo '<p>Date de liberté : ' . $appart['date_libre'] . '</p>';
            echo '<p>Prix : ' . $appart['prix_loc'] . '</p>';
            echo '<p>Rue : ' . $appart['rue'] . '</p>';
            echo '<p>Type appartement : ' . $appart['typappart'] . '</p>';
            echo '</a>';
        }
    } else {
        echo '<p>Aucun appartement trouvé.</p>';
    }
    ?>

</body>
</html>


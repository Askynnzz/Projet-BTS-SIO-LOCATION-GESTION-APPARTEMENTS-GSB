<?php
session_start();

include '../Modèle/db_config.php';
include '../Modèle/proprietaire.php';

$database = new Database();
$db = $database->getConnection();
$proprietaire = new Proprietaire($db);

if (!isset($_SESSION['user_id'])) {
    header("Location: vueConnexion.php");
    exit();
}

$idProprio = $_SESSION['user_id'];
$idAppartement = $_GET['id'];

$propriete = $proprietaire->getProprieteByIDAPPART($idAppartement);

if (!$propriete) {
    header("Location: vuePropriete.php");
    exit();
}

$propriete = $propriete[0]; // Accéder au premier élément du tableau

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/vueModifierProprietaireStyle.css" rel="stylesheet">
    <title>Modifier la propriété</title>
</head>
<body>

<h2>Modifier la propriété</h2>

<?php if ($propriete): ?>
    <div>
        <form method="post" action="../Contrôleur/ProprioController.php?action=modifier">
            <p>Numéro d'appartement: <input type="text" name="num_appart" value="<?php echo $propriete['NUMAPPART']; ?>"></p>
            <p>Type d'appartement: <input type="text" name="type_appart" value="<?php echo $propriete['TYPAPPART']; ?>"></p>
            <p>Prix de location: <input type="text" name="prix_loc" value="<?php echo $propriete['PRIX_LOC']; ?>"></p>
            <p>Rue: <input type="text" name="rue" value="<?php echo $propriete['RUE']; ?>"></p>
            <p>Arrondissement: <input type="text" name="arrondissement" value="<?php echo $propriete['ARRONDISSE']; ?>"></p>
            <p>Étage: <input type="text" name="etage" value="<?php echo $propriete['ETAGE']; ?>"></p>
            <p>Ascenseur: 
                <input type="checkbox" name="ascenseur" value="1" <?php echo $propriete['ASCENSEUR'] ? 'checked' : ''; ?>>
            </p>
            <p>Préavis: 
                <input type="checkbox" name="preavis" value="1" <?php echo $propriete['PREAVIS'] ? 'checked' : ''; ?>>
            </p>
            <p>Date libre: <input type="date" name="date_libre" value="<?php echo $propriete['DATE_LIBRE']; ?>"></p>
            
            <input type="hidden" name="idAppartement" value="<?php echo $propriete['NUMAPPART']; ?>">
            <input type="submit" value="Confirmer la modification">
        </form>
    </div>
<?php else: ?>
    <p>Aucune propriété trouvée.</p>
<?php endif; ?>

</body>
</html>

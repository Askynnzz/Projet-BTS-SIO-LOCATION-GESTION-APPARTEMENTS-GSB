
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
$listeProprietes = $proprietaire->getProprieteByID($idProprio);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/vueProprieteStyle.css" rel="stylesheet">
    <title>Liste de mes propriétés</title>
    <style>
        .propriete-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .editable {
            display: none;
        }
        .return-button {
            margin-top: 10px;
        }
    </style>
<form method="post" action="../Contrôleur/CotisationController.php?action=Verser ma cotisation à GSB">
    <input type="hidden" name="idProprio" value="<?php echo $idProprio; ?>">
    <input type="submit" name="action" value="Verser ma cotisation à GSB"> 
</form>


<h2>Mes propriétés</h2>

<?php
if ($listeProprietes) {
    foreach ($listeProprietes as $propriete) {
        echo '<div class="propriete-box">';
        echo '<p><strong>Numéro de l\'appartement :</strong> <span class="value">' . $propriete['NUMAPPART'] . '</span></p>';
            echo '<p><strong>Type d\'appartement :</strong> <span class="value">' . $propriete['TYPAPPART'] . '</span></p>';
            echo '<p><strong>Prix de location :</strong> <span class="value">' . $propriete['PRIX_LOC'] . '</span></p>';
            echo '<p><strong>Prix des charges :</strong> <span class="value">' . $propriete['PRIX_CHARG'] . '</span></p>';
            echo '<p><strong>Adresse :</strong> <span class="value">' . $propriete['RUE'] . '</span></p>';
            echo '<p><strong>Arrondissement :</strong> <span class="value">' . $propriete['ARRONDISSE'] . '</span></p>';
            echo '<p><strong>Étage :</strong> <span class="value">' . $propriete['ETAGE'] . '</span></p>';
            echo '<p><strong>Ascenseur :</strong> <span class="value">' . ($propriete['ASCENSEUR'] ? 'Oui' : 'Non') . '</span></p>';
            echo '<p><strong>Préavis :</strong> <span class="value">' . ($propriete['PREAVIS'] ? 'Oui' : 'Non') . '</span></p>';
            echo '<p><strong>Date libre :</strong> <span class="value">' . $propriete['DATE_LIBRE'] . '</span></p>';
            echo '<a href="../Vue/vueModifierProprietaire.php?id=' . $propriete['NUMAPPART'] . '" class="edit-link">Modifier</a>';
            echo '<a href="../Vue/vueDemandesPropriete.php?id=' . $propriete['NUMAPPART'] . '&arrondissement=' . $propriete['ARRONDISSE'] . '">Voir les demandes</a>';

            echo '</div>';
            
    }
}
?>

</script>
</body>
</html>


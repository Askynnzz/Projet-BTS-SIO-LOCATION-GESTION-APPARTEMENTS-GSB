<?php
include_once '../Modèle/db_config.php';
include_once '../Modèle/demande.php';

$database = new Database();
$db = $database->getConnection();
$demandeAppt = new Demande($db);

if ($_GET['action'] == 'afficherDemandes') {
    $idAppartement = $_GET['idAppartement'];
    $arrondissement = $_GET['arrondissement'];
    
    $demandes = $demandeAppt->getDemandesByArrondissement($arrondissement);

    if ($demandes) {
        foreach ($demandes as $demande) {
            echo '<div class="demande">';
            echo '<p><strong>Numéro de demande :</strong> ' . $demande['NUM_DEM'] . '</p>';
            echo '<p><strong>Type de demande :</strong> ' . $demande['TYPE_DEM'] . '</p>';
            echo '<p><strong>Date limite :</strong> ' . $demande['DATE_LIMITE'] . '</p>';
            echo '<p><strong>Numéro du client :</strong> ' . $demande['NUM_CLI'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>Aucune demande trouvée pour cet arrondissement.</p>';
    }
}

?>

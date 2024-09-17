<?php
include_once '../Contrôleur/GererDemandeController.php';

// Récupérer les paramètres GET
$idAppartement = $_GET['id'];
$arrondissement = $_GET['arrondissement'];

// Appeler la méthode pour récupérer les demandes
$demandes = $demandeAppt->getDemandesByArrondissement($arrondissement);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/vueDemandesProprieteStyle.css" rel="stylesheet">
    <title>Demandes pour l'appartement <?php echo $idAppartement; ?></title>
    <style>
        .demande {
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
        }
        .proposer-button {
            margin-left: 10px;
        }
    </style>
</head>
<body>

<h2>Demandes pour l'appartement <?php echo $idAppartement; ?></h2>

<div class="demandes-list">
    <?php
    if ($demandes) {
        foreach ($demandes as $demande) {
            echo '<div class="demande">';
            echo '<p><strong>Numéro de demande :</strong> ' . $demande['NUM_DEM'] . '</p>';
            echo '<p><strong>Type de demande :</strong> ' . $demande['TYPE_DEM'] . '</p>';
            echo '<p><strong>Date limite :</strong> ' . $demande['DATE_LIMITE'] . '</p>';
            echo '<p><strong>Numéro du client :</strong> ' . $demande['NUM_CLI'] . '</p>';
            
            // Formulaire invisible pour envoyer l'action
            echo '<form method="post" action="../Contrôleur/TraiterPropositionController.php">';
            echo '<input type="hidden" name="action" value="proposerDemande">';
            echo '<input type="hidden" name="demandeId" value="' . $demande['NUM_DEM'] . '">';
            echo '<input type="hidden" name="num_cli" value="' . $demande['NUM_CLI'] . '">';
            
            // Bouton "Proposer" pour soumettre le formulaire
            echo '<button type="submit" class="proposer-button">Proposer</button>';
            
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<p>Aucune demande trouvée pour cet arrondissement.</p>';
    }
    ?>
</div>

</body>
</html>

<?php
session_start();

// Inclure votre classe Demande
include '../Modèle/db_config.php';
include '../Modèle/demande.php';

// Créer une instance de la classe Demande avec la connexion à la base de données
$database = new Database();
$db = $database->getConnection();
$demande = new Demande($db);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: vueConnexion.php");
    exit();
}

$idClient = $_SESSION['user_id'];

// Traiter la demande si proposerId est présent dans le cookie
if (isset($_COOKIE['proposerId'])) {
    $idPropose = $_COOKIE['proposerId'];
    
    // Mettre à jour la demande pour indiquer qu'elle a été proposée
    $demande->traiterDemande($idPropose, $idClient);
    
    // Supprimer le cookie
    setcookie('proposerId', '', time() - 3600, '/');
}

// Récupérer la liste des demandes
$listeDemandes = $demande->voirListeDemande($idClient);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/vueDemandeClientStyle.css" rel="stylesheet">
    <title>Liste de mes demandes</title>
    <style>
        .rapport-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        
        /* Style pour la checkbox */
        .custom-checkbox {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
        }
        
        /* Style pour la checkbox cochée (traitée) */
        .custom-checkbox.checked {
            background-color: #8bc34a; /* Couleur verte */
            border-color: #8bc34a;
        }
        
        /* Style pour le label de la checkbox */
        .checkbox-label {
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
        
        /* Style pour la checkbox cliquable */
        .custom-checkbox.clickable {
            cursor: pointer;
        }

    </style>
</head>
<body>

    <h2>Liste de mes demandes</h2>

    <?php
    if ($listeDemandes) {
        foreach ($listeDemandes as $demandeItem) {
            // Vérifier si la demande a été traitée
            $demandeTraitee = $demande->isTraitee($demandeItem['num_dem'], $idClient);
            
            // Ajouter une classe supplémentaire si la demande a été traitée
            $checkboxClass = $demandeTraitee ? 'checked' : '';
            
            // Créer un lien si la demande est traitée
            if ($demandeTraitee) {
                echo '<a href="../Vue/vueAppartementPropose.php?num_dem=' . $demandeItem['num_dem'] . '" class="rapport-box">';
            } else {
                echo '<div class="rapport-box">';
            }
            
            echo '<div class="custom-checkbox ' . $checkboxClass . '"></div>';
            echo '<span class="checkbox-label">ID de la demande : ' . $demandeItem['num_dem'] . ' - Date limite : ' . $demandeItem['date_limite'] . ' - Type de la demande : ' . $demandeItem['type_dem'] . '</span>';
            
            // Fermer le lien ou la div
            if ($demandeTraitee) {
                echo '</a>';
            } else {
                echo '</div>';
            }
        }
    } else {
        echo '<p>Aucune demande trouvée.</p>';
    }
    ?>

</body>
</html>

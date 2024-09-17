<?php
session_start();

// Inclure votre classe Rapport
include '../Modèle/db_config.php';
include '../Modèle/locataire.php';


// Créer une instance de la classe Rapport avec la connexion à la base de données
$database = new Database();
$db = $database->getConnection();
$location = new Locataire($db);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: vueConnexion.php");
    exit();
}

// Récupérer l'ID de l'utilisateur connecté
$idLocataire = $_SESSION['user_id'];

// Appeler la méthode pour récupérer la liste des rapports de l'utilisateur
$listeLocations = $location->getLocationByIDLocataire($idLocataire);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/vueLocataireStyle.css" rel="stylesheet">
    <title>Liste de mes locations</title>
    <style>
        .location-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .editable {
            display: none;
        }
    </style>
</head>
<body>

    <h2>Mes locations</h2>

    <?php
    if ($listeLocations) {
        foreach ($listeLocations as $location) {
            // Afficher les détails de la location
            echo '<div class="location-box">';
            echo '<p><strong>Numéro de l\'appartement :</strong> <span class="value">' . $location['NUMAPPART'] . '</span><input type="text" class="editable" name="num_appart" value="' . $location['NUMAPPART'] . '"></p>';
            echo '<p><strong>Type d\'appartement :</strong> <span class="value">' . $location['TYPAPPART'] . '</span><input type="text" class="editable" name="type_appart" value="' . $location['TYPAPPART'] . '"></p>';
            echo '<p><strong>Prix de location :</strong> <span class="value">' . $location['PRIX_LOC'] . '</span><input type="text" class="editable" name="prix_loc" value="' . $location['PRIX_LOC'] . '"></p>';
            echo '<p><strong>Prix des charges :</strong> <span class="value">' . $location['PRIX_CHARG'] . '</span><input type="text" class="editable" name="prix_charg" value="' . $location['PRIX_CHARG'] . '"></p>';
            echo '<p><strong>Adresse :</strong> <span class="value">' . $location['RUE'] . '</span><input type="text" class="editable" name="rue" value="' . $location['RUE'] . '"></p>';
            echo '<p><strong>Arrondissement :</strong> <span class="value">' . $location['ARRONDISSE'] . '</span><input type="text" class="editable" name="arrondissement" value="' . $location['ARRONDISSE'] . '"></p>';
            echo '<p><strong>Étage :</strong> <span class="value">' . $location['ETAGE'] . '</span><input type="text" class="editable" name="etage" value="' . $location['ETAGE'] . '"></p>';
            echo '<p><strong>Ascenseur :</strong> <span class="value">' . ($location['ASCENSEUR'] ? 'Oui' : 'Non') . '</span><input type="checkbox" class="editable" name="ascenseur" value="1" ' . ($location['ASCENSEUR'] ? 'checked' : '') . '></p>';
            echo '<p><strong>Préavis :</strong> <span class="value">' . ($location['PREAVIS'] ? 'Oui' : 'Non') . '</span><input type="checkbox" class="editable" name="preavis" value="1" ' . ($location['PREAVIS'] ? 'checked' : '') . '></p>';
            echo '<p><strong>Date libre :</strong> <span class="value">' . $location['DATE_LIBRE'] . '</span><input type="date" class="editable" name="date_libre" value="' . $location['DATE_LIBRE'] . '"></p>';
            echo '<button class="edit-button">Modifier</button>';
            echo '</div>';
        }
    } else {
        echo '<p>Aucune location trouvée.</p>';
    }
    ?>

<form method="post" action="../Contrôleur/LocataireController.php?action=suppression">
    <input type="hidden" name="idLocataire" value="<?php echo $idLocataire; ?>">
    <input type="submit" name="action" value="Résilier ma location">
</form>


    <script>
        // Ajouter un événement clic sur chaque bouton de modification
        var editButtons = document.querySelectorAll('.edit-button');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var locationBox = this.parentElement;
                var editableFields = locationBox.querySelectorAll('.editable');
                var valueFields = locationBox.querySelectorAll('.value');

                // Afficher les champs éditables et masquer les champs de valeur
                editableFields.forEach(function(field) {
                    field.style.display = 'inline-block';
                });
                valueFields.forEach(function(field) {
                    field.style.display = 'none';
                });
                this.style.display = 'none'; // Masquer le bouton de modification
            });
        });
    </script>

</body>
</html>

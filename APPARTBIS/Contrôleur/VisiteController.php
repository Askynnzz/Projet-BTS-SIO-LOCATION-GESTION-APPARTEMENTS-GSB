<?php
include_once '../Modèle/db_config.php';
include_once '../Modèle/Visite.php'; // Assurez-vous que le chemin est correct

$database = new Database();
$db = $database->getConnection();
$visite = new Visite($db);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'Visiter') {
    $idAppart = $_POST['idAppart'];
    $idClient = $_POST['idClient'];
    $idDemande = $_POST['idDemande'];
    if ($visite->ajouterVisite($idAppart, $idClient)) {
        // Rediriger ou afficher un message de succès
        header("Location: ../Vue/vueAppartementPropose.php?num_dem=$idDemande");
        echo ("Visite réalisée ! Vous pouvez désormais louer l'appartement si vous êtes intéresser");
        exit();
    } else {
        echo "Erreur lors de la visite de l'appartement.";
    }
}
?>

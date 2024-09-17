<?php
include_once '../Modèle/db_config.php';
include_once '../Modèle/locataire.php'; // Assurez-vous que le chemin est correct
$database = new Database();
$db = $database->getConnection();

$locataire = new Locataire($db);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'Louer') {
    
    $idAppart = $_POST['idAppart'];
    $idClient = $_POST['idClient'];

    if ($locataire->devenirLocataire($idAppart, $idClient)) { 
        // Rediriger ou afficher un message de succès
        header("Location: ../Vue/vueLocataire.php");
        exit();
    } else {
        echo "Erreur lors de la location de l'appartement.";
    }
}

?>

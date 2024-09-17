<?php
session_start();
include_once '../Modèle/demande.php';
include_once '../Modèle/db_config.php';
$database = new Database();
$db = $database->getConnection();

$demande = new Demande($db);

if (isset($_POST['action'])) {
    $action = $_POST['action'];
  
    if ($action == 'DemandeLocation') {
        $typAppart = $_POST['typAppart'];
        $idClient = $_POST['idClient'];
        $dateLimite = $_POST['datelimite'];
        $arrondissement = $_POST['arrondissement'];
        if ($demande->CréerDemande($typAppart, $idClient, $dateLimite, $arrondissement)) {
            // demande effectuée
            exit;

        } else {
            echo "Erreur lors de la demande.";
        }
    }






}
?>
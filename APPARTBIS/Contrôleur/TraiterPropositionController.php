<?php

include_once '../Modèle/db_config.php';
include_once '../Modèle/demande.php';

$database = new Database();
$db = $database->getConnection();
$demandeAppt = new Demande($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'proposerDemande') {
    $demandeId = $_POST['demandeId'];
    $idClient = $_POST['num_cli'];
    
    if($demandeAppt->traiterDemande($demandeId, $idClient)){
        echo"Demande traitée !" . $demandeId . "est le numéro de la demande et" . $idClient . "est le numéro du client";
    }else {
        echo "Erreur pour la demande " . $demandeId . " du client " . $idClient;

    };
}
?>
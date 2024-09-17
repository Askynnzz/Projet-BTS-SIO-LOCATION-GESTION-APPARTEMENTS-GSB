<?php
session_start();
include_once '../Modèle/locataire.php';
include_once '../Modèle/db_config.php';
$database = new Database();
$db = $database->getConnection();

$locataire = new Locataire($db);

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    $idLocataire = $_POST['idLocataire'];
   
    if ($action == 'Résilier ma location') {
        
        
        if($locataire->resilierLocation($idLocataire)){
            exit;
        }else {
            echo "echec lors de la résilisation";
        }
    }


}
?>
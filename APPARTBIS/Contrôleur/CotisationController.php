<?php
session_start();
include_once '../Modèle/proprietaire.php';
include_once '../Modèle/db_config.php';
$database = new Database();
$db = $database->getConnection();

$proprietaire = new Proprietaire($db);

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $idProprio = $_POST['idProprio'];
    
    if ($action == 'Verser ma cotisation à GSB') {
        
        $proprietaire->cotiser($idProprio);
        
        exit;
    }


}
?>
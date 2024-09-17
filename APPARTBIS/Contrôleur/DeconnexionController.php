<?php
session_start();
include_once '../Modèle/clients.php';
include_once '../Modèle/db_config.php';
$database = new Database();
$db = $database->getConnection();

$client = new Client($db);

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'Se deconnecter') {
        
        $client->logout();
        header("Location: ../Vue/vueConnexion.php");
        exit;
    }


}
?>
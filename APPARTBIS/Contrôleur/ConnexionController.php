<?php
session_start();
include_once '../Modèle/clients.php';
include_once '../Modèle/locataire.php';
include_once '../Modèle/proprietaire.php';
include_once '../Modèle/db_config.php';
$database = new Database();
$db = $database->getConnection();

$client = new Client($db);
$proprietaire = new Proprietaire($db);
$locataire = new Locataire($db);
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    
    if ($action == 'Se connecter') {
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];

        
        if ($client->login($login, $mdp)) {
            // Connexion réussie
            exit;
    }
    elseif ($locataire->login($login, $mdp)) {
        // Connexion réussie
        exit;
}

    elseif ($proprietaire->login($login, $mdp)) {
        // Connexion réussie
        exit;
}



}
}
?>
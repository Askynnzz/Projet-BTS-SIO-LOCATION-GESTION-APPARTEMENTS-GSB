<?php
session_start();
include_once '../Modèle/proprietaire.php';
include_once '../Modèle/db_config.php';
$database = new Database();
$db = $database->getConnection();
$proprietaire = new Proprietaire($db);



 
        $numAppart = $_POST['num_appart'];
        $typAppart = $_POST['type_appart'];
        $prix_loc = $_POST['prix_loc'];
        $prix_charg = $_POST['prix_charg'];
        $rue = $_POST['rue'];
        $arrondissement = $_POST['arrondissement'];
        $etage = $_POST['etage'];
        $ascenceur = $_POST['ascenseur'];
        $preavis = $_POST['preavis'];
        $date_libre = $_POST['date_libre'];

        
        if ($proprietaire->UpdateAppartProprio($numAppart, $typAppart, $prix_loc, $prix_charg, $rue, $arrondissement, $etage, $ascenceur, $preavis, $date_libre)) {
            // mise a jour effectuée
           
            exit;

        } else {
            echo "Erreur lors de la mise a jour des données de l'appartement.";
        }
        
  
?>



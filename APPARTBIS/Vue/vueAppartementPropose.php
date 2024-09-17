<html>
<link href="../assets/vueAppartementProposeStyle.css" rel="stylesheet">
</html>

<?php
session_start();

include '../Modèle/db_config.php';
include '../Modèle/Demande.php'; 
include '../Modèle/Appartement.php';  
include '../Modèle/Visite.php';  


$database = new Database();
$db = $database->getConnection();

$appartement = new Appartement($db);
$visite = new Visite($db);

if (!isset($_SESSION['user_id'])) {
    header("Location: vueConnexion.php");
    exit();
}

$idClient = $_SESSION['user_id'];

if (isset($_GET['num_dem'])) {
    $idDemande = $_GET['num_dem'];
  
    // Récupérer les détails de la demande et de l'appartement proposé
    $details = $appartement->getDemandeAppartementDetails($idDemande);
    
    $estVisite = $visite->estVisite($details['NUMAPPART'], $idClient);
    

    if ($details) {
        
        ?>
        <div>
        
            <p>Type de demande: <?php echo $details['TYPE_DEM']; ?></p>
            <p>Date limite: <?php echo $details['DATE_LIMITE']; ?></p>
            <p>Arrondissement: <?php echo $details['ARRONDISS_DEM']; ?></p>
            
            <h3>Appartement proposé:</h3>
            <p>Numéro d'appartement: <?php echo $details['NUMAPPART']; ?></p>
            <p>Type d'appartement: <?php echo $details['TYPAPPART']; ?></p>
            <p>Prix de location: <?php echo $details['PRIX_LOC']; ?></p>
            <p>Rue: <?php echo $details['RUE']; ?></p>
            
            <form method="post" action="../Contrôleur/VisiteController.php">
            <input type="hidden" name="idAppart" value="<?php echo $details['NUMAPPART']; ?>">
            <input type="hidden" name="idDemande" value="<?php echo $idDemande; ?>">
            <input type="hidden" name="idClient" value="<?php echo $idClient; ?>">
            <input type="submit" name="action" value="Visiter">
            </form>

            <?php if ($estVisite): ?>
            <form method="post" action="../Contrôleur/LouerController.php">
                <input type="hidden" name="idAppart" value="<?php echo $details['NUMAPPART']; ?>">
                <input type="hidden" name="idClient" value="<?php echo $idClient; ?>">
                <input type="submit" name="action" value="Louer">
            </form>
        <?php endif; ?>
        </div>
        <?php
    } else {
        echo "Aucun détail trouvé pour cette demande.";
    }
} else {
    header("Location: vueClient.php");
    exit();
}
?>

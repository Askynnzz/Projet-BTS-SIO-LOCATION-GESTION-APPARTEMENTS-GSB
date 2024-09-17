<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'appartement</title>
    <link href="../assets/vueAppartStyle.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Détails de l'appartement</h2>
        <?php
        session_start();
        include '../Modèle/db_config.php';
        include '../Modèle/Appartement.php';
        $idClient = $_SESSION['user_id'];
        $nomClient = $_SESSION['user_name'];
        echo "<p>Bonjour, " . $nomClient . "</p>";

        $database = new Database();
        $db = $database->getConnection();
        $appart = new Appartement($db);

        if (isset($_GET['id'])) {
            $idAppart = $_GET['id'];
            $detailsAppart = $appart->getDetailsAppart($idAppart);

            if ($detailsAppart) {
                // Affichage des détails de l'appartement
                ?>
                <div class="appart-details">
                    <p><strong>Numéro d'appartement:</strong> <?php echo $detailsAppart['numappart']; ?></p>
                    <p><strong>Type d'appartement:</strong> <?php echo $detailsAppart['typappart']; ?></p>
                    <p><strong>Prix de location:</strong> <?php echo $detailsAppart['prix_loc']; ?></p>
                    <p><strong>Rue:</strong> <?php echo $detailsAppart['rue']; ?></p>
                    <p><strong>Arrondissement:</strong> <?php echo $detailsAppart['arrondisse']; ?></p>
                    <p><strong>Étage:</strong> <?php echo $detailsAppart['etage']; ?></p>
                    <p><strong>Ascenseur:</strong> <?php echo $detailsAppart['ascenseur'] ? 'Oui' : 'Non'; ?></p>
                    <p><strong>Préavis:</strong> <?php echo $detailsAppart['preavis']; ?></p>
                    <p><strong>Date libre:</strong> <?php echo $detailsAppart['date_libre']; ?></p>
                    <p><strong>Numéro du propriétaire:</strong> <?php echo $detailsAppart['numeroprop']; ?></p>
                </div>
                <?php
                // Vérification de la date libre
                $dateLibre = strtotime($detailsAppart['date_libre']);
                $aujourdHui = strtotime(date('Y-m-d'));
                if ($dateLibre < $aujourdHui) {
                    ?>
                    <form class="demande-form" method="post" action="../Contrôleur/DemandeController.php?action=DemandeLocation">
                        <input type="hidden" name="idAppart" value="<?php echo $idAppart; ?>">
                        <input type="hidden" name="typAppart" value="<?php echo $detailsAppart['typappart']; ?>">
                        <input type="hidden" name="idClient" value="<?php echo $idClient; ?>">

                        <label for="datelimite">Date limite de location:</label>
                        <input type="date" name="datelimite" required>
                        
                        <label for="arrondissement">Arrondissement demandé:</label>
                        <input type="text" name="arrondissement" required>
                        
                        <input type="submit" name="action" value="DemandeLocation" class="submit-btn">
                    </form>
                    <?php
                } else {
                    echo "<p class='date-info'>La date libre n'est pas encore passée.</p>";
                }
            } else {
                echo "<p class='error-msg'>Aucun détail trouvé pour cet appartement.</p>";
            }
        } else {
            header("Location: vueClient.php");
            exit();
        }
        ?>
    </div>
</body>
</html>

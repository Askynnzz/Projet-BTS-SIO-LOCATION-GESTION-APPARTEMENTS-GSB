<?php
include_once 'db_config.php';

class Appartement
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function insererRapport($date, $motif, $bilan, $idVisiteur, $idMedecin)
    {
        $sql = "INSERT INTO rapport (date, motif, bilan, idVisiteur, idMedecin) VALUES (:date, :motif, :bilan, :idVisiteur, :idMedecin)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':motif', $motif);
        $stmt->bindParam(':bilan', $bilan);
        $stmt->bindParam(':idVisiteur', $idVisiteur);
        $stmt->bindParam(':idMedecin', $idMedecin);
        $stmt->execute();
    }

    public function voirListeAppart() {
        $sql = "SELECT numappart, typappart, prix_loc, rue FROM appartements";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
    
        // Récupérer les résultats de la requête
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultats;
    }

    public function getDetailsAppart($idAppart) {
        $sql = "SELECT numappart, typappart, prix_loc, rue, arrondisse, etage, ascenseur, preavis, date_libre, numeroprop FROM appartements WHERE numappart = :idAppart";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAppart', $idAppart);
        $stmt->execute();

        // Récupérer les détails du rapport
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDemandeAppartementDetails($idDemande) {
        $query = "SELECT * FROM demande_appartement WHERE NUM_DEM = :idDemande";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idDemande', $idDemande);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    
}



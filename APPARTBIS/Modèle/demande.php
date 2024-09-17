<?php
include_once 'db_config.php';
class Demande
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function CréerDemande($typAppart, $idClient, $dateLimite, $arrondissement)
    {
        
        $sql = "INSERT INTO demandes (type_dem, date_limite, num_cli) VALUES (:typAppart, :dateLimite, :idClient)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':typAppart', $typAppart);
        $stmt->bindParam(':dateLimite', $dateLimite);
        $stmt->bindParam(':idClient', $idClient);
        $stmt->execute();
        
        $numDem = $this->conn->lastInsertId();
        $sql2 = "INSERT INTO concerner (num_dem, arrondiss_dem) VALUES (:numDem, :arrondissement)";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->bindParam(':numDem', $numDem);
        $stmt2->bindParam(':arrondissement', $arrondissement);
        $stmt2->execute();

        echo "demande effectuée , veuillez consulter votre page de demandes pour consulter la réponse lorsqu'elle sera présente.";    
    }


    
    public function voirListeDemande($idClient) {
        $sql = "SELECT num_dem, type_dem, date_limite FROM demandes WHERE num_cli = :idClient";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idClient', $idClient);
        $stmt->execute();
    
        // Récupérer les résultats de la requête
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultats;
    }

    public function getDemandesByArrondissement($arrondissement){
        $sql = "SELECT d.* FROM demandes d
        INNER JOIN concerner c ON d.NUM_DEM = c.NUM_DEM
        WHERE c.ARRONDISS_DEM = :arrondissement";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':arrondissement', $arrondissement);

        $stmt->execute();

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
      

    }

    public function traiterDemande($idPropose, $idClient) {
        $query = "UPDATE demandes SET TRAITEE = 1 WHERE NUM_DEM = :idPropose AND NUM_CLI = :idClient";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idPropose', $idPropose);
        $stmt->bindParam(':idClient', $idClient);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isTraitee($idDemande, $idClient) {
        $sql = "SELECT TRAITEE FROM demandes WHERE NUM_DEM = :idDemande AND NUM_CLI = :idClient";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idDemande', $idDemande);
        $stmt->bindParam(':idClient', $idClient);
        
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && isset($result['TRAITEE'])) {
            return $result['TRAITEE'] == 1;
        } else {
            return false;
        }
    }
    
    



}
?>
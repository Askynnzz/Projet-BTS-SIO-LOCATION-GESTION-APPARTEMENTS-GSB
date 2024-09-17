<?php
include_once 'db_config.php';

class Visite
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }


    
    public function ajouterVisite($idAppart, $idClient) {
        $query = "INSERT INTO visiter (NUMAPPART, NUM_CLI, DATE_VISITE) VALUES (:idAppart, :idClient, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idAppart', $idAppart);
        $stmt->bindParam(':idClient', $idClient);

        return $stmt->execute();
}

// Dans la classe Visite
public function estVisite($idAppart, $idClient) {
    $query = "SELECT * FROM visiter WHERE NUMAPPART = :idAppart AND NUM_CLI = :idClient";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':idAppart', $idAppart);
    $stmt->bindParam(':idClient', $idClient);

    $stmt->execute();

    return $stmt->rowCount() > 0; // Retourne vrai si une visite a été trouvée
}


    
    
}



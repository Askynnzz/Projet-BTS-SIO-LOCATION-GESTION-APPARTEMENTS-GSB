<?php
include_once 'db_config.php';
class Locataire
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Méthode pour créer un compte visiteur
   

    // Méthode pour se connecter

    public function login($login, $mdp)
    {
        $query = "SELECT numeroloc, nom_loc, prenom_loc, datenaiss, tel_loc, r_i_b, tel_banque, numappart, login, mdp FROM locataires WHERE login = :login AND mdp = :mdp";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":mdp", $mdp);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Démarrer la session
            session_start();

            // Stocker l'ID de l'utilisateur dans la session
            $_SESSION['user_id'] = $row['numeroloc'];
            $_SESSION['user_name'] = $row['nom_loc']; // Ajoutez d'autres informations utilisateur si nécessaire
            
            header("Location:../Vue/vueLocataire.php");
        } else {
            return false; // Identifiants incorrects
        }
    }

    public function voirListeLocation($idLocataire) {
        $sql = "SELECT numeroloc, type_dem, date_limite FROM demandes WHERE num_loc = :idLocataire";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idLocataire', $idLocataire);
        $stmt->execute();
    
        // Récupérer les résultats de la requête
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultats;
    }


    public function getLocationByIDLocataire($idLocataire){
        $sql = "SELECT a.NUMAPPART, a.TYPAPPART, a.PRIX_LOC, a.PRIX_CHARG, a.RUE, a.ARRONDISSE, a.ETAGE, a.ASCENSEUR, a.PREAVIS, a.DATE_LIBRE
        FROM locataires l
        INNER JOIN appartements a ON l.NUMAPPART = a.NUMAPPART
        WHERE l.NUMEROLOC = :idLocataire";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idLocataire', $idLocataire);
        $stmt->execute();
    
        // Récupérer les résultats de la requête
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultats;

    }

    public function resilierLocation($numeroLocataire) {
        try {
            // Récupération des informations du locataire
            $stmtSelectLocataire = $this->conn->prepare("SELECT * FROM locataires WHERE NUMEROLOC = :numeroLocataire");
            $stmtSelectLocataire->bindParam(':numeroLocataire', $numeroLocataire);
            $stmtSelectLocataire->execute();
            
            $locataire = $stmtSelectLocataire->fetch(PDO::FETCH_ASSOC);
            
            if (!$locataire) {
                return false; // Locataire non trouvé
            }
            
            // Insertion du client
            $stmtInsertClient = $this->conn->prepare("INSERT INTO clients (NOM_CLI, ADRESSE_CLI, CODEVILLE_CLI, TEL_CLI, login, mdp) VALUES (:nom, :adresse, :codeville, :tel, :login, :mdp)");
            $stmtInsertClient->bindParam(':nom', $locataire['NOM_LOC']);
            $stmtInsertClient->bindParam(':adresse', $locataire['ADRESSE']);
            $stmtInsertClient->bindParam(':codeville', $locataire['CODE_VILLE']);
            $stmtInsertClient->bindParam(':tel', $locataire['TEL_LOC']);
            $stmtInsertClient->bindParam(':login', $locataire['login']);
            $stmtInsertClient->bindParam(':mdp', $locataire['mdp']);
            
            if (!$stmtInsertClient->execute()) {
                return false; // Erreur lors de l'insertion du client
            }
            
            // Suppression du locataire
            $stmtDeleteLocataire = $this->db->prepare("DELETE FROM locataires WHERE NUMEROLOC = :numeroLocataire");
            $stmtDeleteLocataire->bindParam(':numeroLocataire', $numeroLocataire);
            
            if (!$stmtDeleteLocataire->execute()) {
                return false; // Erreur lors de la suppression du locataire
            }
            
            return true; // Succès
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    


    // Dans la classe Louer

public function devenirLocataire($idAppart, $idClient) {
    // Récupérer les informations du client
    $query = "SELECT * FROM clients WHERE NUM_CLI = :idClient";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':idClient', $idClient);
    $stmt->execute();
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    

    // Insertion dans la table locataires
    $queryLocataire = "INSERT INTO locataires (NOM_LOC, TEL_LOC, NUMAPPART, login, mdp) VALUES (:nom, :tel, :idAppart, :login, :mdp)";
    $stmtLocataire = $this->conn->prepare($queryLocataire);
    $stmtLocataire->bindParam(':nom', $client['NOM_CLI']);
    $stmtLocataire->bindParam(':tel', $client['TEL_CLI']);
    $stmtLocataire->bindParam(':idAppart', $idAppart);
    $stmtLocataire->bindParam(':login', $client['login']);
    $stmtLocataire->bindParam(':mdp', $client['mdp']);
    

    try {
        if (!$stmtLocataire->execute()) {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur d'exécution de la requête : " . $e->getMessage();
        return false;
    }

   
    // Suppression des demandes liées au client
    $stmtDeleteDemandes = $this->conn->prepare("DELETE FROM demandes WHERE NUM_CLI = :num_cli");
    $stmtDeleteDemandes->bindParam(':num_cli', $num_cli);
    try {
        if (!$stmtDeleteDemandes->execute()) {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur d'exécution de la requête : " . $e->getMessage();
        return false;
    }

    // Suppression des visites liées au client
    $stmtDeleteVisite = $this->conn->prepare("DELETE FROM visiter WHERE NUM_CLI = :num_cli");
    $stmtDeleteVisite->bindParam(':num_cli', $num_cli);
    try {
        if (!$stmtDeleteVisite->execute()) {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur d'exécution de la requête : " . $e->getMessage();
        return false;
    }


    // Suppression du client
    $stmtDeleteClient = $this->conn->prepare("DELETE FROM clients WHERE NUM_CLI = :num_cli");
    $stmtDeleteClient->bindParam(':num_cli', $num_cli);
    try {
        if (!$stmtDeleteClient->execute()) {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur d'exécution de la requête : " . $e->getMessage();
        return false;
    }

    return true;
}




    public function logout() {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Détruire toutes les données de session
        session_unset();
        
        // Détruire la session
        session_destroy();
    }
}
?>
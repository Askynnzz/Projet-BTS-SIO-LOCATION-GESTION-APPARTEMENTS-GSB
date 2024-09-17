<?php
include_once 'db_config.php';
class Proprietaire
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
        $query = "SELECT numeroprop, nom, prenom, adresse, code_ville, tel, login, mdp FROM proprietaires WHERE login = :login AND mdp = :mdp";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":mdp", $mdp);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Démarrer la session
            session_start();

            // Stocker l'ID de l'utilisateur dans la session
            $_SESSION['user_id'] = $row['numeroprop'];
            $_SESSION['user_name'] = $row['nom']; // Ajoutez d'autres informations utilisateur si nécessaire
            
            header("Location:../Vue/vueProprietaire.php");
        } else {
            return false; // Identifiants incorrects
        }
    }



    public function getProprieteByID($idProprio){
        $sql = "SELECT a.NUMAPPART, a.TYPAPPART, a.PRIX_LOC, a.PRIX_CHARG, a.RUE, a.ARRONDISSE, a.ETAGE, a.ASCENSEUR, a.PREAVIS, a.DATE_LIBRE, a.NUMEROPROP
        FROM appartements a
        INNER JOIN proprietaires p ON a.NUMEROPROP = p.NUMEROPROP
        WHERE a.NUMEROPROP = :idProprio";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idProprio', $idProprio);
        $stmt->execute();
    
        // Récupérer les résultats de la requête
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultats;

    }

    public function getProprieteByIDAPPART($idAppart){
        $sql = "SELECT a.NUMAPPART, a.TYPAPPART, a.PRIX_LOC, a.PRIX_CHARG, a.RUE, a.ARRONDISSE, a.ETAGE, a.ASCENSEUR, a.PREAVIS, a.DATE_LIBRE, a.NUMEROPROP
        FROM appartements a
        INNER JOIN proprietaires p ON a.NUMEROPROP = p.NUMEROPROP
        WHERE a.NUMAPPART = :idAppart";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAppart', $idAppart);
        $stmt->execute();
    
        // Récupérer les résultats de la requête
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultats;

    }


    public function UpdateAppartProprio($numAppart, $typAppart, $prix_loc, $prix_charg, $rue, $arrondissement, $etage, $ascenseur, $preavis, $date_libre) {
        // Requête SQL pour mettre à jour les informations de l'appartement
        $query = "UPDATE appartements SET TYPAPPART = :typAppart, PRIX_LOC = :prix_loc, PRIX_CHARG = :prix_charg, RUE = :rue, ARRONDISSE = :arrondissement, ETAGE = :etage, ASCENSEUR = :ascenseur, PREAVIS = :preavis, DATE_LIBRE = :date_libre WHERE NUMAPPART = :numAppart";
        echo $etage;
        // Préparation de la requête
        $stmt = $this->conn->prepare($query);
    
        // Liaison des paramètres
        $stmt->bindParam(':numAppart', $numAppart);
        $stmt->bindParam(':typAppart', $typAppart);
        $stmt->bindParam(':prix_loc', $prix_loc);
        $stmt->bindParam(':prix_charg', $prix_charg);
        $stmt->bindParam(':rue', $rue);
        $stmt->bindParam(':arrondissement', $arrondissement);
        $stmt->bindParam(':etage', $etage);
        $stmt->bindParam(':ascenseur', $ascenseur);
        $stmt->bindParam(':preavis', $preavis);
        $stmt->bindParam(':date_libre', $date_libre);
        
        
        // Exécution de la requête
        if ($stmt->execute()) {
            
            header("Location:../Vue/vuePropriete.php");
            echo $numAppart;
            
        } else {
            return false; // Échec de la mise à jour
        }
    }

    public function cotiser($idProprio){
        $query = "SELECT calculer_cotisation(:idProprio) AS cotisation";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProprio', $idProprio);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $cotisation = $result['cotisation'];
        echo "La cotisation pour le propriétaire $idProprio est de : $cotisation";
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
<?php
include_once 'db_config.php';
class Client
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
        $query = "SELECT num_cli, nom_cli, adresse_cli, codeville_cli, tel_cli, login, mdp FROM clients WHERE login = :login AND mdp = :mdp";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":mdp", $mdp);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Démarrer la session
            session_start();

            // Stocker l'ID de l'utilisateur dans la session
            $_SESSION['user_id'] = $row['num_cli'];
            $_SESSION['user_name'] = $row['nom_cli']; // Ajoutez d'autres informations utilisateur si nécessaire
            
            header("Location:../Vue/vueClient.php");
        } else {
            return false; // Identifiants incorrects
        }
    }




    // Méthode pour se déconnecter (peut être vide dans ce cas)
    public function logout()
    {
        // Vous pouvez implémenter une logique de déconnexion ici si nécessaire
    }
}
?>
<?php
class Database {
    private $host = "localhost"; // Adresse du serveur MySQL
    private $db_name = "yberrichi_apappartements"; // Nom de la base de données
    private $username = "root"; // Nom d'utilisateur MySQL
    private $password = ""; // Mot de passe MySQL
    public $conn; // Instance de connexion PDO

    // Méthode de connexion à la base de données
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

<?php
// config/db.php - Configuration de la base de données corrigée



class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        // Configuration de la base de données
        $host = 'localhost';
        $dbname = 'Confiance';
        $user = 'root';
        $pass = '';

        try {

            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

        } catch (PDOException $e) {
            // Afficher l'erreur détaillée
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Méthode pour obtenir l'instance unique de la base de données (Singleton)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Méthode pour obtenir la connexion PDO
    public function getConnection()
    {
        return $this->pdo;
    }

    // Méthode pour exécuter une requête SQL avec des paramètres
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Enregistrer l'erreur dans les logs
            error_log("Erreur SQL : " . $e->getMessage() . " | Requête : " . $sql);
            // Afficher l'erreur pour le débogage
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    // Méthode pour obtenir le dernier ID inséré
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    // Méthode pour commencer une transaction
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    // Méthode pour valider une transaction
    public function commit()
    {
        return $this->pdo->commit();
    }

    // Méthode pour annuler une transaction
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }
}

// Initialisation de la connexion à la base de données
try {
    $db = Database::getInstance();
} catch (Exception $e) {
    die("Impossible d'initialiser la base de données : " . $e->getMessage());
}

<?php
require_once dirname(__DIR__, 3) . '/admin/system/env_loader.php';
loadEnv(dirname(__DIR__, 3) . '/.env');

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // Fallback to $_SERVER if $_ENV is empty due to php.ini, or use defaults
        $this->host = $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? 'localhost';
        $this->db_name = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? 'leogroup_db';
        $this->username = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? 'leogroup_user';
        $this->password = $_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? '';
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            // Secure connection attributes
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
        } catch(PDOException $exception) {
            http_response_code(500);
            echo json_encode(["error" => "Database connection failed.", "details" => $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}
?>

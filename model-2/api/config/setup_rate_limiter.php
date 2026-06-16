<?php
require_once 'd:/internship work/leogroup main website/model-2/api/config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    $query = "CREATE TABLE IF NOT EXISTS login_attempts (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45) NOT NULL,
        attempt_time DATETIME NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    try {
        $db->exec($query);
        echo "Table created successfully.";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
require_once '../config/security.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));
$data = sanitize_payload($data);

if (empty($data->uname) || empty($data->pwd)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing credentials."]);
    exit;
}

$database = new Database();
$db = $database->getConnection();

$client_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

// Enforce 5 attempts per 15 minutes limit using central security wrapper
check_rate_limit($db, $client_ip, 'login', 5, 15);

// Parameterized Query: Mathematically eliminates SQL Injection
$query = "SELECT id, costomer_id, password, status FROM user WHERE costomer_id = :uname AND status = 1 LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(':uname', $data->uname, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch();
    $stored_password = $row['password'];
    $valid_password = false;

    // Modern verification (for already migrated passwords)
    if (password_verify($data->pwd, $stored_password)) {
        $valid_password = true;
    } 
    // Legacy Password Upgrader: Seamlessly upgrades plaintext to bcrypt on first successful login
    elseif ($stored_password === $data->pwd) {
        $valid_password = true;
        $new_hash = password_hash($data->pwd, PASSWORD_DEFAULT);
        
        $update_query = "UPDATE user SET password = :hash WHERE id = :id";
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bindParam(':hash', $new_hash, PDO::PARAM_STR);
        $update_stmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
        $update_stmt->execute();
    }

    if ($valid_password) {
        // Clear IP slate on successful login
        $clear_ip = "DELETE FROM api_rate_limits WHERE ip_address = :ip AND endpoint = 'login'";
        $stmt_clear = $db->prepare($clear_ip);
        $stmt_clear->bindParam(':ip', $client_ip, PDO::PARAM_STR);
        $stmt_clear->execute();

        // Prevent session fixation attacks
        session_regenerate_id(true);
        $_SESSION['co_id'] = $row['costomer_id'];
        $_SESSION['logged_in'] = true;

        http_response_code(200);
        echo json_encode(["message" => "Authentication successful", "redirect" => "../user/"]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials."]);
    }
} else {
    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials."]);
}
?>

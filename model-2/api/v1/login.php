<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';

// Ensure strictly POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));

if (empty($data->uname) || empty($data->pwd)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing credentials."]);
    exit;
}

$database = new Database();
$db = $database->getConnection();

$client_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

// Step 1: Clean up attempts older than 15 minutes
$clear_query = "DELETE FROM login_attempts WHERE attempt_time < (NOW() - INTERVAL 15 MINUTE)";
$db->exec($clear_query);

// Step 2: Check current lockout status
$check_lockout = "SELECT COUNT(*) as attempt_count FROM login_attempts WHERE ip_address = :ip";
$stmt_lockout = $db->prepare($check_lockout);
$stmt_lockout->bindParam(':ip', $client_ip, PDO::PARAM_STR);
$stmt_lockout->execute();
$lockout_data = $stmt_lockout->fetch();

if ($lockout_data['attempt_count'] >= 5) {
    http_response_code(429);
    echo json_encode(["error" => "Too many failed attempts. Your IP has been temporarily locked out for 15 minutes."]);
    exit;
}

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
        $clear_ip = "DELETE FROM login_attempts WHERE ip_address = :ip";
        $stmt_clear = $db->prepare($clear_ip);
        $stmt_clear->bindParam(':ip', $client_ip, PDO::PARAM_STR);
        $stmt_clear->execute();

        // Prevent session fixation attacks
        session_regenerate_id(true);
        $_SESSION['co_id'] = $row['costomer_id'];
        $_SESSION['logged_in'] = true;

        http_response_code(200);
        echo json_encode(["message" => "Authentication successful", "redirect" => "dashboard.html"]);
    } else {
        // Record failed attempt
        $insert_attempt = "INSERT INTO login_attempts (ip_address, attempt_time) VALUES (:ip, NOW())";
        $stmt_insert = $db->prepare($insert_attempt);
        $stmt_insert->bindParam(':ip', $client_ip, PDO::PARAM_STR);
        $stmt_insert->execute();

        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials."]);
    }
} else {
    // Record failed attempt
    $insert_attempt = "INSERT INTO login_attempts (ip_address, attempt_time) VALUES (:ip, NOW())";
    $stmt_insert = $db->prepare($insert_attempt);
    $stmt_insert->bindParam(':ip', $client_ip, PDO::PARAM_STR);
    $stmt_insert->execute();

    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials."]);
}
?>

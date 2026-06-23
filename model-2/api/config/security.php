<?php
// Enforce Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("Content-Security-Policy: default-src 'none'");

// Payload Size Limitation (1MB max)
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
    if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 1048576) {
        http_response_code(413);
        echo json_encode(["error" => "Payload too large. Maximum size is 1MB."]);
        exit;
    }
}

// Recursive function to sanitize inputs
function sanitize_payload($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize_payload($value);
        }
    } else if (is_object($data)) {
        foreach ($data as $key => $value) {
            $data->$key = sanitize_payload($value);
        }
    } else if (is_string($data)) {
        $data = strip_tags(str_replace(chr(0), '', $data));
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    return $data;
}

// Automatically sanitize all incoming superglobals
$_GET = sanitize_payload($_GET);
$_POST = sanitize_payload($_POST);
$_COOKIE = sanitize_payload($_COOKIE);

// Generic Rate Limiter Logic
function check_rate_limit($db, $client_ip, $endpoint, $max_attempts = 60, $time_window_minutes = 1) {
    try {
        // Clean up old attempts
        $clear_query = "DELETE FROM api_rate_limits WHERE attempt_time < (NOW() - INTERVAL :window MINUTE) AND endpoint = :endpoint";
        $stmt_clear = $db->prepare($clear_query);
        $stmt_clear->bindValue(':window', $time_window_minutes, PDO::PARAM_INT);
        $stmt_clear->bindValue(':endpoint', $endpoint, PDO::PARAM_STR);
        $stmt_clear->execute();

        // Check current lockout status
        $check_lockout = "SELECT COUNT(*) as attempt_count FROM api_rate_limits WHERE ip_address = :ip AND endpoint = :endpoint";
        $stmt_lockout = $db->prepare($check_lockout);
        $stmt_lockout->bindValue(':ip', $client_ip, PDO::PARAM_STR);
        $stmt_lockout->bindValue(':endpoint', $endpoint, PDO::PARAM_STR);
        $stmt_lockout->execute();
        $lockout_data = $stmt_lockout->fetch();

        if ($lockout_data['attempt_count'] >= $max_attempts) {
            http_response_code(429);
            echo json_encode(["error" => "Rate limit exceeded for $endpoint. Try again in $time_window_minutes minutes."]);
            exit;
        }

        // Record this attempt immediately
        $insert_attempt = "INSERT INTO api_rate_limits (ip_address, endpoint, attempt_time) VALUES (:ip, :endpoint, NOW())";
        $stmt_insert = $db->prepare($insert_attempt);
        $stmt_insert->bindValue(':ip', $client_ip, PDO::PARAM_STR);
        $stmt_insert->bindValue(':endpoint', $endpoint, PDO::PARAM_STR);
        $stmt_insert->execute();
    } catch (PDOException $e) {
        // Silently bypass rate limiting if the table does not exist in production yet
        // In a strict environment, you might want to log $e->getMessage() here.
        return;
    }
}
?>

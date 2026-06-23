<?php
session_start();
header('Content-Type: application/json');

// Ensure user is authenticated
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['co_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access. Please log in."]);
    exit;
}

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/config/security.php';

$database = new Database();
$db = $database->getConnection();
$cos_id = $_SESSION['co_id'];
$client_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

// Global API rate limit: 60 requests per minute
check_rate_limit($db, $client_ip, 'ledger', 60, 1);

// Get requested date, default to today
$date_filter = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date("Y-m-d");

try {
    // Parameterized PDO query to mathematically eliminate SQL injection
    $query = "SELECT code, name, prate, op_stock, purchase_qty, purchase_free, preturn, 
              sales_qty, sales_free, salesqty_spoke, salesfree_spoke, s_value, s_return, 
              excess, short, cl_stock, cl_stock_spoke, cl_value 
              FROM ledger 
              WHERE costomer_id = :cid AND date = :fdate 
              ORDER BY name ASC";
              
    $stmt = $db->prepare($query);
    $stmt->bindParam(':cid', $cos_id, PDO::PARAM_STR);
    $stmt->bindParam(':fdate', $date_filter, PDO::PARAM_STR);
    $stmt->execute();
    
    $ledger_data = [];
    $s_value_total = 0;
    $cl_value_total = 0;
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ledger_data[] = $row;
        $s_value_total += (float)$row['s_value'];
        $cl_value_total += (float)$row['cl_value'];
    }
    
    echo json_encode([
        "status" => "success",
        "date_filtered" => $date_filter,
        "records" => count($ledger_data),
        "data" => $ledger_data,
        "totals" => [
            "s_value" => $s_value_total,
            "cl_value" => $cl_value_total
        ]
    ]);

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database query failed.", "details" => $e->getMessage()]);
}
?>

<?php
require_once 'api/config/database.php';
try {
    $db = (new Database())->getConnection();
    $sql = file_get_contents('api/config/rate_limit.sql');
    $db->exec($sql);
    echo 'Done';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

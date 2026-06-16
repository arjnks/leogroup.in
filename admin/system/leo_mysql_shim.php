<?php
// Polyfill wrapper to safely migrate legacy mysql_* calls to mysqli_* globally
$leo_global_conn = null;

function leo_mysql_connect($host, $user, $pass) {
    global $leo_global_conn;
    $leo_global_conn = mysqli_connect($host, $user, $pass);
    return $leo_global_conn;
}

function leo_mysql_select_db($db, $conn = null) {
    global $leo_global_conn;
    $c = $conn ?: $leo_global_conn;
    return mysqli_select_db($c, $db);
}

function leo_mysql_query($query, $conn = null) {
    global $leo_global_conn;
    $c = $conn ?: $leo_global_conn;
    return mysqli_query($c, $query);
}

function leo_mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
    if (!$result) return false;
    return mysqli_fetch_array($result, $result_type);
}

function leo_mysql_fetch_assoc($result) {
    if (!$result) return false;
    return mysqli_fetch_assoc($result);
}

function leo_mysql_num_rows($result) {
    if (!$result) return false;
    return mysqli_num_rows($result);
}

function leo_mysql_error($conn = null) {
    global $leo_global_conn;
    $c = $conn ?: $leo_global_conn;
    return mysqli_error($c);
}

function leo_mysql_real_escape_string($escapestr, $conn = null) {
    global $leo_global_conn;
    $c = $conn ?: $leo_global_conn;
    return mysqli_real_escape_string($c, $escapestr);
}

function leo_mysql_close($conn = null) {
    global $leo_global_conn;
    $c = $conn ?: $leo_global_conn;
    return mysqli_close($c);
}

function leo_mysql_insert_id($conn = null) {
    global $leo_global_conn;
    $c = $conn ?: $leo_global_conn;
    return mysqli_insert_id($c);
}

function leo_mysql_affected_rows($conn = null) {
    global $leo_global_conn;
    $c = $conn ?: $leo_global_conn;
    return mysqli_affected_rows($c);
}
?>

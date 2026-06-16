<?php
require_once __DIR__ . '/env_loader.php';
loadEnv(dirname(__DIR__, 2) . '/.env');

// Secure Session Cookie Settings (Hardening)
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Strict');

// Polyfill script for massive db migration
require_once __DIR__ . '/leo_mysql_shim.php';
?>

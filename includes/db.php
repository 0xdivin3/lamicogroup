<?php
/**
 * Lamico Group — Database Connection
 * Edit these credentials to match your cPanel MySQL setup.
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'ouwfipvq_lamico');       // e.g. lamicogrp_user
define('DB_PASS', 'yamallamico');
define('DB_NAME', 'ouwfipvq_lamico');       // e.g. lamicogrp_db

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // In production, log this instead of printing
    error_log('DB connection failed: ' . $e->getMessage());
    http_response_code(500);
    die(json_encode(['success' => false, 'message' => 'Database error. Please try again later.']));
}

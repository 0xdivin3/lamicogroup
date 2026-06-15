<?php
/**
 * Lamico Group Admin — Auth Helper
 * Change ADMIN_PASSWORD to a strong password before deploying.
 */
session_start();

define('ADMIN_PASSWORD', 'putyouradminpasswordhere'); // ← CHANGE THIS

function is_logged_in(): bool {
    return isset($_SESSION['lamico_admin']) && $_SESSION['lamico_admin'] === true;
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: ' . admin_url('index.php'));
        exit;
    }
}

function admin_url(string $path = ''): string {
    // Use BASE_URL if config already loaded, otherwise build it
    if (defined('BASE_URL')) {
        return BASE_URL . 'admin/' . ltrim($path, '/');
    }
    $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host  = $_SERVER['HTTP_HOST'];
    $dir   = rtrim(str_replace('\\', '/', dirname(__DIR__)), '/');
    $doc   = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
    $sub   = str_replace($doc, '', $dir);
    return $proto . '://' . $host . $sub . '/admin/' . ltrim($path, '/');
}

function site_url(string $path = ''): string {
    if (defined('BASE_URL')) {
        return BASE_URL . ltrim($path, '/');
    }
    $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host  = $_SERVER['HTTP_HOST'];
    $dir   = rtrim(str_replace('\\', '/', dirname(__DIR__)), '/');
    $doc   = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
    $sub   = str_replace($doc, '', $dir);
    return $proto . '://' . $host . $sub . '/' . ltrim($path, '/');
}

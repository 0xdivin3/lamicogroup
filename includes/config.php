<?php
/**
 * Lamico Group — Central Config
 * Determines the site root URL reliably regardless of which subfolder the page is in.
 */

// Absolute path to the project root on disk (the folder containing index.php)
define('ROOT_PATH', dirname(__DIR__));

// Build base URL from the document root
$_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$_host     = $_SERVER['HTTP_HOST'];

// Find how deep the project root sits relative to the web server document root
$_doc_root  = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$_root_path = rtrim(str_replace('\\', '/', ROOT_PATH), '/');
$_sub_path  = str_replace($_doc_root, '', $_root_path);

define('BASE_URL', $_protocol . '://' . $_host . $_sub_path . '/');

// Shorthand helper so any file can just call base_url('pages/about.php')
function base_url(string $path = ''): string {
    return BASE_URL . ltrim($path, '/');
}

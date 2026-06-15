<?php
require_once 'auth.php';
$_SESSION = [];
session_destroy();
header('Location: ' . admin_url('index.php'));
exit;

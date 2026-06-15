<?php
require_once 'auth.php';

// Redirect if already logged in
if (is_logged_in()) {
    header('Location: ' . admin_url('dashboard.php'));
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password === ADMIN_PASSWORD) {
        $_SESSION['lamico_admin'] = true;
        $_SESSION['login_time']   = time();
        header('Location: ' . admin_url('dashboard.php'));
        exit;
    } else {
        $error = 'Incorrect password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Lamico Group</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
<div class="login-page">
  <div class="login-card">
    <img src="../assets/images/logo.png" alt="Lamico Group" onerror="this.style.display='none'">
    <h1>Lamico Group</h1>
    <p>Admin Panel — Enter your password to continue</p>

    <?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="password">Admin Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required autofocus>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:8px;">
        🔐 Sign In
      </button>
    </form>

    <p style="margin-top:24px;font-size:.78rem;color:var(--text-muted);">
      <a href="<?= site_url('index.php') ?>" style="color:var(--gold);">← Back to website</a>
    </p>
  </div>
</div>
</body>
</html>

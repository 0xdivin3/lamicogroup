<?php
$admin_page = $admin_page ?? '';
$page_title = $admin_page ? ucfirst($admin_page) . ' — Lamico Admin' : 'Admin — Lamico Group';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= admin_url('admin.css') ?>">
</head>
<body>
<div class="admin-wrap">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <img src="<?= site_url('assets/images/logo.png') ?>" alt="Lamico" onerror="this.style.display='none'">
      <span>Lamico <em>Admin</em></span>
    </div>

    <div class="sidebar-section">Main</div>
    <nav class="sidebar-nav">
      <a href="<?= admin_url('dashboard.php') ?>" class="<?= $admin_page === 'dashboard' ? 'active' : '' ?>">
        <span class="nav-icon">📊</span> Dashboard
      </a>
      <div class="sidebar-section" style="padding-top:12px;">Content</div>
      <a href="<?= admin_url('services.php') ?>" class="<?= $admin_page === 'services' ? 'active' : '' ?>">
        <span class="nav-icon">🏢</span> Services
      </a>
      <a href="<?= admin_url('gallery.php') ?>" class="<?= $admin_page === 'gallery' ? 'active' : '' ?>">
        <span class="nav-icon">🖼️</span> Gallery
      </a>
      <a href="<?= admin_url('testimonials.php') ?>" class="<?= $admin_page === 'testimonials' ? 'active' : '' ?>">
        <span class="nav-icon">⭐</span> Testimonials
      </a>
      <div class="sidebar-section" style="padding-top:12px;">Enquiries</div>
      <a href="<?= admin_url('bookings.php') ?>" class="<?= $admin_page === 'bookings' ? 'active' : '' ?>">
        <span class="nav-icon">📅</span> Bookings
      </a>
      <a href="<?= admin_url('contacts.php') ?>" class="<?= $admin_page === 'contacts' ? 'active' : '' ?>">
        <span class="nav-icon">✉️</span> Contact Messages
      </a>
    </nav>

    <div class="sidebar-footer">
      <a href="<?= site_url('index.php') ?>" target="_blank">🌐 View Website</a>
      <a href="<?= admin_url('logout.php') ?>" style="margin-top:4px;">🚪 Sign Out</a>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="admin-main">
    <div class="admin-topbar">
      <span class="topbar-title"><?= ucfirst($admin_page ?: 'Admin') ?></span>
      <div class="topbar-right">
        <span class="topbar-badge">Admin</span>
        <a href="<?= admin_url('logout.php') ?>" class="btn btn-outline btn-sm">Sign Out</a>
      </div>
    </div>
    <div class="admin-content">

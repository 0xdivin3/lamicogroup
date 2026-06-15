<?php
require_once __DIR__ . '/config.php';

// Set default meta if not defined by the calling page
$page_title       = $page_title       ?? 'Lamico Group — Multi-Industry Conglomerate';
$page_description = $page_description ?? 'A multi-industry conglomerate offering services in construction, media, ICT, hospitality, publishing, and global commerce across Africa.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
  <title><?= htmlspecialchars($page_title) ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

  <!-- Open Graph -->
  <meta property="og:title"       content="<?= htmlspecialchars($page_title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
  <meta property="og:type"        content="website">
  <meta property="og:url"         content="<?= BASE_URL ?>">
  <meta property="og:image"       content="<?= base_url('assets/images/og-image.jpg') ?>">
</head>
<body>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true">
  <span class="lightbox-close" id="lightbox-close" aria-label="Close">&times;</span>
  <img id="lightbox-img" src="" alt="Gallery image">
</div>

<!-- NAVBAR -->
<nav class="navbar" role="navigation" aria-label="Main navigation">
  <div class="container navbar-inner">

    <a href="<?= base_url('index.php') ?>" class="navbar-logo" aria-label="Lamico Group home">
      <img src="<?= base_url('assets/images/logo.png') ?>" alt="Lamico Group logo" onerror="this.style.display='none'">
      <span class="logo-text">Lamico <span>Group</span></span>
    </a>

    <ul class="nav-links" role="list">
      <li><a href="<?= base_url('index.php') ?>">Home</a></li>
      <li><a href="<?= base_url('pages/services.php') ?>">Our Business</a></li>
      <li><a href="<?= base_url('pages/gallery.php') ?>">Gallery</a></li>
      <li><a href="<?= base_url('pages/about.php') ?>">About</a></li>
      <li><a href="<?= base_url('pages/contact.php') ?>">Contact</a></li>
      <li class="nav-cta">
        <a href="<?= base_url('pages/booking.php') ?>" class="btn btn-primary">Book a Consultation</a>
      </li>
    </ul>

    <button class="hamburger" aria-label="Toggle navigation" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

  </div>
</nav>

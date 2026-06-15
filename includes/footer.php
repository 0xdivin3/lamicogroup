<?php if (!defined('BASE_URL')) require_once __DIR__ . '/config.php'; ?>

<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="footer-grid">

      <!-- Brand -->
      <div class="footer-brand">
        <div class="footer-logo">
          <img src="<?= base_url('assets/images/logo.png') ?>" alt="Lamico Group" onerror="this.style.display='none'">
          <span>Lamico <em>Group</em></span>
        </div>
        <p>A dynamic multi-industry conglomerate committed to innovation, quality, and excellence across Africa.</p>
      </div>

      <!-- Quick Links -->
      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="<?= base_url('index.php') ?>">Home</a></li>
          <li><a href="<?= base_url('pages/about.php') ?>">About Us</a></li>
          <li><a href="<?= base_url('pages/services.php') ?>">Our Business</a></li>
          <li><a href="<?= base_url('pages/gallery.php') ?>">Gallery</a></li>
          <li><a href="<?= base_url('pages/contact.php') ?>">Contact</a></li>
        </ul>
      </div>

      <!-- Services -->
      <div class="footer-col">
        <h4>Our Services</h4>
        <ul>
          <li><a href="<?= base_url('pages/services.php') ?>#construction">Gold-Stone Constructions</a></li>
          <li><a href="<?= base_url('pages/services.php') ?>#media">Gold Dust Press</a></li>
          <li><a href="<?= base_url('pages/services.php') ?>#ict">Rashtech Global Solutions</a></li>
          <li><a href="<?= base_url('pages/services.php') ?>#commerce">Lamico Interbiz Resources</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="footer-col">
        <h4>Contact Us</h4>
        <ul>
          <li><a href="mailto:info@lamicogroup.org">info@lamicogroup.org</a></li>
          <li><a href="tel:+2348000000000">+234 800 000 0000</a></li>
          <li><a href="<?= base_url('pages/booking.php') ?>">Book a Consultation</a></li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> Lamico Group. All rights reserved.</span>
      <span>Built with care &mdash; <a href="<?= base_url('pages/contact.php') ?>">Get in touch</a></span>
    </div>
  </div>
</footer>

<script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>

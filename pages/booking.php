<?php
$page_title       = 'Book a Consultation — Lamico Group';
$page_description = 'Schedule a consultation with Lamico Group across any of our business divisions.';
require_once '../includes/header.php';
require_once '../includes/db.php';

$services    = $pdo->query('SELECT * FROM services WHERE active=1 ORDER BY order_num ASC')->fetchAll();
$preselected = htmlspecialchars($_GET['service'] ?? '');
?>

<section class="page-hero">
  <div class="container">
    <span class="tag" style="color:var(--gold-light);">Schedule a Meeting</span>
    <h1>Book a Consultation</h1>
    <p>Tell us about your project and we'll arrange a consultation with the right team.</p>
    <div class="breadcrumb">
      <a href="../index.php">Home</a>
      <span>/</span>
      <span>Book a Consultation</span>
    </div>
  </div>
</section>

<section class="section booking-section">
  <div class="container">
    <div class="booking-inner reveal">
      <div class="section-title">
        <span class="tag">Get Started</span>
        <h2 style="font-size:1.8rem;">Request an Appointment</h2>
        <p style="max-width:460px;margin:12px auto 0;">Fill in the details below and our team will confirm your consultation within 24 hours.</p>
      </div>

      <div id="booking-msg" class="form-msg"></div>

      <form id="booking-form" novalidate>
        <div class="form-row">
          <div class="form-group">
            <label for="b-name">Full Name *</label>
            <input type="text" id="b-name" name="name" placeholder="Your full name" required>
          </div>
          <div class="form-group">
            <label for="b-email">Email Address *</label>
            <input type="email" id="b-email" name="email" placeholder="your@email.com" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="b-phone">Phone Number</label>
            <input type="tel" id="b-phone" name="phone" placeholder="+234 800 000 0000">
          </div>
          <div class="form-group">
            <label for="b-date">Preferred Date</label>
            <input type="date" id="b-date" name="date" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="b-service">Service / Division *</label>
          <select id="b-service" name="service" required>
            <option value="" disabled selected>Select a service area</option>
            <?php foreach ($services as $svc): ?>
            <option value="<?= htmlspecialchars($svc['name']) ?>"
              <?= ($preselected === $svc['name']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($svc['icon'] . ' ' . $svc['name']) ?>
            </option>
            <?php endforeach; ?>
            <option value="General Enquiry">🏢 General Enquiry</option>
          </select>
        </div>
        <div class="form-group">
          <label for="b-message">Additional Notes</label>
          <textarea id="b-message" name="message" placeholder="Briefly describe your project, goals, or any questions you have..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:15px;">
          Book Appointment
        </button>
        <p style="font-size:.78rem;color:var(--text-muted);text-align:center;margin-top:14px;">
          We'll confirm your appointment by email within 24 hours.
        </p>
      </form>
    </div>
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>

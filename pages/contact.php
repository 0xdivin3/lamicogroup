<?php
$page_title       = 'Contact Us — Lamico Group';
$page_description = 'Get in touch with Lamico Group. We\'re ready to discuss your project and how we can help.';
require_once '../includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <span class="tag" style="color:var(--gold-light);">Reach Out</span>
    <h1>Contact Us</h1>
    <p>Have a question or project in mind? We'd love to hear from you.</p>
    <div class="breadcrumb">
      <a href="../index.php">Home</a>
      <span>/</span>
      <span>Contact</span>
    </div>
  </div>
</section>

<section class="section">
  <div class="container contact-grid">

    <!-- Info -->
    <div class="contact-info reveal">
      <span class="tag">Get in Touch</span>
      <h2>We're Here to Help</h2>
      <div class="divider"></div>
      <p>Reach out to us directly or fill in the form and we'll respond within one business day.</p>

      <div class="contact-details">
        <div class="contact-item">
          <div class="contact-icon">📍</div>
          <div>
            <strong>Office Address</strong>
            <span>Lamico Group Headquarters, Nigeria</span>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">📧</div>
          <div>
            <strong>Email</strong>
            <span><a href="mailto:info@lamicogroup.org" style="color:var(--gold);">info@lamicogroup.org</a></span>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">📞</div>
          <div>
            <strong>Phone</strong>
            <span><a href="tel:+2348000000000" style="color:var(--gold);">+234 800 000 0000</a></span>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">🕐</div>
          <div>
            <strong>Business Hours</strong>
            <span>Monday – Friday: 8am – 5pm WAT</span>
          </div>
        </div>
      </div>

      <div style="margin-top:36px;">
        <a href="booking.php" class="btn btn-primary">Book a Consultation Instead →</a>
      </div>
    </div>

    <!-- Form -->
    <div class="reveal">
      <div class="form-card">
        <h3 style="margin-bottom:6px;">Send Us a Message</h3>
        <p style="font-size:.88rem;margin-bottom:28px;">We'll get back to you within 24 hours.</p>

        <div id="form-msg" class="form-msg"></div>

        <form id="contact-form" novalidate>
          <div class="form-row">
            <div class="form-group">
              <label for="name">Full Name *</label>
              <input type="text" id="name" name="name" placeholder="John Doe" required>
            </div>
            <div class="form-group">
              <label for="email">Email Address *</label>
              <input type="email" id="email" name="email" placeholder="john@company.com" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" placeholder="+234 800 000 0000">
            </div>
            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" id="subject" name="subject" placeholder="How can we help?">
            </div>
          </div>
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" placeholder="Tell us about your project or enquiry..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
            Send Message
          </button>
        </form>
      </div>
    </div>

  </div>
</section>

<?php require_once '../includes/footer.php'; ?>

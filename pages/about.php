<?php
$page_title       = 'About Us — Lamico Group';
$page_description = 'Learn about Lamico Group — our story, mission, vision, and the values that drive our multi-industry conglomerate across Africa.';
require_once '../includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <span class="tag" style="color:var(--gold-light);">Our Story</span>
    <h1>About Lamico Group</h1>
    <p>A conglomerate built on vision, values, and a relentless drive to create lasting impact across Africa.</p>
    <div class="breadcrumb">
      <a href="../index.php">Home</a>
      <span>/</span>
      <span>About</span>
    </div>
  </div>
</section>

<!-- Story -->
<section class="section">
  <div class="container about-grid">
    <div class="about-img-wrap reveal">
      <img src="../assets/images/about-photo.jpg" alt="Lamico Group leadership"
           onerror="this.src='https://placehold.co/600x450/0F1B2D/FFFFFF?text=Lamico+Group'">
      <div class="about-badge">
        <strong>2014</strong>
        <span>Year<br>Founded</span>
      </div>
    </div>
    <div class="about-text reveal">
      <span class="tag">Who We Are</span>
      <h2>Discover the Lamico Group Story</h2>
      <div class="divider"></div>
      <p>Founded to unify several thriving businesses under one strategic vision, Lamico Group is a dynamic, multi-industry conglomerate. We operate across construction, media, ICT, and international commerce — bringing operational excellence and brand consistency to every venture.</p>
      <p>Our group was born from the belief that Africa deserves world-class services delivered by homegrown expertise. Over a decade, we have grown from a regional business into a trusted partner for clients across the continent.</p>
      <p>Every subsidiary under the Lamico umbrella is led by sector specialists who combine deep industry knowledge with a passion for innovation — ensuring our clients receive not just a service, but a partnership built for the long term.</p>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section class="section-sm" style="background:var(--mist);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
  <div class="container">
    <div class="why-grid" style="--why-cols:2;">
      <div class="why-card reveal" style="background:var(--navy);border-color:rgba(255,255,255,.08);">
        <div class="why-icon">🎯</div>
        <h3 style="color:var(--white);">Our Mission</h3>
        <p>To deliver integrated, high-quality solutions that drive sustainable growth for our clients and communities across Africa — with integrity, innovation, and impact at the core of everything we do.</p>
      </div>
      <div class="why-card reveal" style="background:var(--navy);border-color:rgba(255,255,255,.08);">
        <div class="why-icon">🌍</div>
        <h3 style="color:var(--white);">Our Vision</h3>
        <p>To become Africa's most trusted multi-industry conglomerate — a name synonymous with excellence, reliability, and positive change across every sector we serve.</p>
      </div>
    </div>
  </div>
</section>

<!-- Values -->
<section class="section">
  <div class="container">
    <div class="services-header reveal">
      <span class="tag">What We Stand For</span>
      <h2>Our Core Values</h2>
      <div class="divider" style="margin:16px auto 20px;"></div>
    </div>
    <div class="why-grid" style="margin-top:0;">
      <?php
      $values = [
        ['🤝','Integrity','We hold ourselves to the highest standards of honesty and transparency in all business dealings.'],
        ['💡','Innovation','We constantly seek smarter, better ways to serve our clients and evolve with the market.'],
        ['🏆','Excellence','Mediocrity is not an option. Every project, every deliverable, every interaction reflects our commitment to quality.'],
        ['🌿','Sustainability','We build with the future in mind — socially, economically, and environmentally responsible business.'],
        ['👥','Collaboration','The best outcomes emerge from strong partnerships — with our clients, our communities, and each other.'],
        ['🚀','Impact','Everything we do is measured by the real, lasting difference it makes for the people and businesses we serve.'],
      ];
      foreach ($values as $v): ?>
      <div class="why-card reveal">
        <div class="why-icon"><?= $v[0] ?></div>
        <h3><?= $v[1] ?></h3>
        <p><?= $v[2] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container">
    <h2>Let's Build Something Together</h2>
    <p>Whether you need construction, media, tech, or trade expertise — Lamico Group is your partner.</p>
    <div class="cta-actions">
      <a href="../pages/booking.php" class="btn btn-primary">Book a Consultation</a>
      <a href="../pages/contact.php" class="btn btn-outline" style="border-color:rgba(255,255,255,.3);color:#fff;">Get in Touch</a>
    </div>
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>

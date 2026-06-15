<?php
$page_title       = 'Lamico Group — Innovating Success Across Africa';
$page_description = 'A multi-industry conglomerate offering services in construction, media, ICT, hospitality, publishing, and global commerce across Africa.';
require_once 'includes/header.php';
require_once 'includes/db.php';

// Fetch services and testimonials from DB

$services = $pdo->query('SELECT * FROM services WHERE active=1 ORDER BY order_num ASC LIMIT 4')->fetchAll();
$testimonials = $pdo->query('SELECT * FROM testimonials WHERE active=1 ORDER BY id ASC LIMIT 3')->fetchAll();
?>

<!-- ═══════════════════════════════ HERO ═══════════════════ -->
<section class="hero">
  <div class="container hero-grid">

    <div class="hero-content">
      <div class="hero-tag">Est. 2014 &mdash; Pan-African Conglomerate</div>
      <h1>Innovating <em>Success</em><br>Across Every Industry</h1>
      <p class="hero-sub">A multi-industry conglomerate delivering excellence in construction, media, ICT, and global commerce across Africa.</p>
      <div class="hero-actions">
        <a href="pages/services.php" class="btn btn-primary">Explore Our Business</a>
        <a href="pages/contact.php" class="btn btn-outline" style="border-color:rgba(255,255,255,.3);color:#fff;">Get in Touch</a>
      </div>
      <div class="hero-stats">
        <div>
          <div class="hero-stat-num">10+</div>
          <div class="hero-stat-label">Years of Experience</div>
        </div>
        <div>
          <div class="hero-stat-num">150+</div>
          <div class="hero-stat-label">Happy Clients</div>
        </div>
        <div>
          <div class="hero-stat-num">4</div>
          <div class="hero-stat-label">Business Divisions</div>
        </div>
      </div>
    </div>

    <div class="hero-visual" aria-hidden="true">
      <div class="hero-card-stack">
        <div class="hero-card-float f1">
          <span class="dot"></span> Active across 5+ countries
        </div>
        <div class="hero-card">
          <?php foreach ($services as $svc): ?>
          <div class="service-pill">
            <div class="pill-icon"><?= $svc['icon'] ?></div>
            <div>
              <div class="pill-name"><?= htmlspecialchars($svc['name']) ?></div>
              <div class="pill-sector">Business Division</div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="hero-card-float f2">
          <span class="dot"></span> 99.9% client satisfaction rate
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ═══════════════════════════════ SERVICES ══════════════ -->
<section class="section" id="services">
  <div class="container">
    <div class="services-header reveal">
      <span class="tag">Our Business Divisions</span>
      <h2>Diverse Solutions, One Group</h2>
      <div class="divider" style="margin:16px auto 20px;"></div>
      <p>At Lamico Group, each subsidiary brings focused expertise — united by a shared commitment to quality and client success.</p>
    </div>

    <div class="services-grid">
      <?php foreach ($services as $i => $svc): ?>
      <div class="service-card reveal">
        <div class="svc-num">0<?= $i+1 ?></div>
        <div class="svc-icon"><?= $svc['icon'] ?></div>
        <h3><?= htmlspecialchars($svc['name']) ?></h3>
        <p><?= htmlspecialchars($svc['short_desc']) ?></p>
        <a href="pages/services.php#<?= $svc['slug'] ?>" class="svc-link">Learn More &rarr;</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ ABOUT STRIP ═══════════ -->
<section class="section about-strip">
  <div class="container">
    <div class="about-grid">

      <div class="about-img-wrap reveal">
        <img src="assets/images/about-photo.jpg" alt="Lamico Group team" onerror="this.src='https://placehold.co/600x450/0F1B2D/FFFFFF?text=Lamico+Group'">
        <div class="about-badge">
          <strong>10+</strong>
          <span>Years of<br>Excellence</span>
        </div>
      </div>

      <div class="about-text reveal">
        <span class="tag">Who We Are</span>
        <h2>The Lamico Group Story</h2>
        <div class="divider"></div>
        <p>Founded to unify several thriving businesses, Lamico Group is a dynamic conglomerate operating across construction, media, technology, and international commerce — with a mission to ensure brand consistency and operational excellence.</p>
        <p>From civil engineering projects that shape Nigeria's infrastructure to digital platforms empowering governance, we bring world-class expertise to every engagement.</p>

        <div class="about-vals">
          <div class="about-val">
            <div class="about-val-icon">🎯</div>
            <div class="about-val-body">
              <h4>Our Mission</h4>
              <p>To deliver integrated, high-quality solutions that drive sustainable growth for our clients and communities across Africa.</p>
            </div>
          </div>
          <div class="about-val">
            <div class="about-val-icon">🌍</div>
            <div class="about-val-body">
              <h4>Our Vision</h4>
              <p>To become Africa's most trusted multi-industry conglomerate, known for integrity, innovation, and impact.</p>
            </div>
          </div>
        </div>

        <a href="pages/about.php" class="btn btn-primary" style="margin-top:32px;">More About Us</a>
      </div>

    </div>
  </div>
</section>

<!-- ═══════════════════════════════ WHY US ════════════════ -->
<section class="section why-section">
  <div class="container">
    <div class="why-header reveal">
      <span class="tag">Why Choose Us</span>
      <h2>The Lamico Advantage</h2>
      <div class="divider" style="margin:16px auto 20px;"></div>
    </div>
    <div class="why-grid">
      <div class="why-card reveal">
        <div class="why-icon">🔬</div>
        <h3>Diverse Expertise</h3>
        <p>Our multi-sector presence enables comprehensive solutions across any industry, tailored to your specific requirements.</p>
      </div>
      <div class="why-card reveal">
        <div class="why-icon">🏆</div>
        <h3>Commitment to Quality</h3>
        <p>We consistently strive to exceed client expectations through innovation and a relentless pursuit of excellence.</p>
      </div>
      <div class="why-card reveal">
        <div class="why-icon">🤝</div>
        <h3>Client-Centric Approach</h3>
        <p>Long-term relationships built on trust. We listen, respond, and deliver — every single time.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ TESTIMONIALS ══════════ -->
<?php if ($testimonials): ?>
<section class="section testimonials-section">
  <div class="container">
    <div class="testimonials-header reveal">
      <span class="tag">Client Feedback</span>
      <h2>What Our Clients Say</h2>
      <div class="divider" style="margin:16px auto 20px;"></div>
    </div>
    <div class="testimonials-grid">
      <?php foreach ($testimonials as $t): ?>
      <div class="testi-card reveal">
        <div class="testi-stars"><?= str_repeat('★', intval($t['rating'])) ?></div>
        <blockquote><?= htmlspecialchars($t['message']) ?></blockquote>
        <div class="testi-author">
          <div class="testi-avatar"><?= strtoupper(substr($t['client_name'],0,1)) ?></div>
          <div>
            <div class="testi-name"><?= htmlspecialchars($t['client_name']) ?></div>
            <div class="testi-role"><?= htmlspecialchars($t['client_role'] . ($t['company'] ? ', ' . $t['company'] : '')) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════ CTA ═══════════════════ -->
<section class="cta-band">
  <div class="container">
    <h2>Ready to Transform Your Business?</h2>
    <p>Partner with Lamico Group and experience our commitment to quality, innovation, and results across every sector.</p>
    <div class="cta-actions">
      <a href="pages/booking.php" class="btn btn-primary">Book a Consultation</a>
      <a href="pages/contact.php" class="btn btn-outline" style="border-color:rgba(255,255,255,.3);color:#fff;">Contact Us</a>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

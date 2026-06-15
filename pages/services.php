<?php
$page_title       = 'Our Business — Lamico Group';
$page_description = 'Explore Lamico Group\'s four business divisions: construction, media, ICT, and international commerce.';
require_once '../includes/header.php';
require_once '../includes/db.php';

$services = $pdo->query('SELECT * FROM services WHERE active=1 ORDER BY order_num ASC')->fetchAll();
?>

<section class="page-hero">
  <div class="container">
    <span class="tag" style="color:var(--gold-light);">What We Do</span>
    <h1>Our Business Divisions</h1>
    <p>Four focused subsidiaries. One unified group. Delivering excellence across Africa.</p>
    <div class="breadcrumb">
      <a href="../index.php">Home</a>
      <span>/</span>
      <span>Our Business</span>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php foreach ($services as $i => $svc): ?>
    <div id="<?= $svc['slug'] ?>" class="about-grid reveal" style="margin-bottom:80px;<?= ($i % 2 !== 0) ? 'direction:rtl;' : '' ?>">
      <div style="<?= ($i % 2 !== 0) ? 'direction:ltr;' : '' ?>">
        <img src="../assets/images/service-<?= $svc['slug'] ?>.jpg"
             alt="<?= htmlspecialchars($svc['name']) ?>"
             style="border-radius:12px;width:100%;aspect-ratio:4/3;object-fit:cover;"
             onerror="this.src='https://placehold.co/600x450/0F1B2D/B8963E?text=<?= urlencode($svc['name']) ?>'">
      </div>
      <div style="<?= ($i % 2 !== 0) ? 'direction:ltr;padding-right:16px;' : 'padding-left:16px;' ?>">
        <span class="tag"><?= htmlspecialchars($svc['icon']) ?> Division 0<?= $i+1 ?></span>
        <h2 style="font-size:clamp(1.5rem,3vw,2rem);"><?= htmlspecialchars($svc['name']) ?></h2>
        <div class="divider"></div>
        <p><?= nl2br(htmlspecialchars($svc['full_desc'])) ?></p>
        <a href="../pages/booking.php?service=<?= urlencode($svc['name']) ?>" class="btn btn-primary" style="margin-top:24px;">
          Enquire About This Service
        </a>
      </div>
    </div>
    <?php if ($i < count($services)-1): ?>
    <hr style="border:none;border-top:1px solid var(--border);margin:0 0 80px;">
    <?php endif; ?>
    <?php endforeach; ?>
  </div>
</section>

<section class="cta-band">
  <div class="container">
    <h2>Partner With Us Today</h2>
    <p>Unlock your business potential with Lamico Group's multi-sector expertise and proven track record.</p>
    <div class="cta-actions">
      <a href="../pages/booking.php" class="btn btn-primary">Book a Consultation</a>
      <a href="../pages/contact.php" class="btn btn-outline" style="border-color:rgba(255,255,255,.3);color:#fff;">Contact Us</a>
    </div>
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>

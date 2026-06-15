<?php
$page_title       = 'Gallery — Lamico Group';
$page_description = 'View Lamico Group\'s portfolio of projects across construction, media, ICT, and commerce.';
require_once '../includes/header.php';
require_once '../includes/db.php';

$gallery_items = $pdo->query('
    SELECT g.*, s.name as service_name
    FROM gallery g
    LEFT JOIN services s ON g.service_id = s.id
    WHERE g.active = 1
    ORDER BY g.created_at DESC
')->fetchAll();

$categories = $pdo->query("SELECT DISTINCT category FROM gallery WHERE active=1 ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>

<section class="page-hero">
  <div class="container">
    <span class="tag" style="color:var(--gold-light);">Portfolio</span>
    <h1>Our Work Gallery</h1>
    <p>A visual showcase of projects and achievements across all our business divisions.</p>
    <div class="breadcrumb">
      <a href="../index.php">Home</a>
      <span>/</span>
      <span>Gallery</span>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="gallery-header reveal">
      <span class="tag">Browse by Category</span>
      <h2>Project Showcase</h2>
      <div class="divider" style="margin:16px auto 0;"></div>
    </div>

    <?php if ($categories): ?>
    <div class="gallery-tabs reveal">
      <button class="gallery-tab active" data-filter="all">All Projects</button>
      <?php foreach ($categories as $cat): ?>
      <button class="gallery-tab" data-filter="<?= htmlspecialchars($cat) ?>">
        <?= htmlspecialchars(ucwords(str_replace('-', ' ', $cat))) ?>
      </button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($gallery_items): ?>
    <div class="gallery-grid">
      <?php foreach ($gallery_items as $item): ?>
      <div class="gallery-item reveal" data-category="<?= htmlspecialchars($item['category']) ?>">
        <img src="../assets/images/gallery/<?= htmlspecialchars($item['filename']) ?>"
             alt="<?= htmlspecialchars($item['caption'] ?? 'Gallery image') ?>"
             loading="lazy">
        <div class="gallery-overlay">
          <?= htmlspecialchars($item['caption'] ?? ($item['service_name'] ?? '')) ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:80px 0;color:var(--text-muted);">
      <div style="font-size:3rem;margin-bottom:16px;">🖼️</div>
      <h3 style="color:var(--navy);margin-bottom:8px;">Gallery Coming Soon</h3>
      <p>Project images will appear here once added by the admin.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>

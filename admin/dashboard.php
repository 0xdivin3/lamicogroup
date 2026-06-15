<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';
$admin_page = 'dashboard';

// Stats
$stats = [
  'services'     => $pdo->query('SELECT COUNT(*) FROM services WHERE active=1')->fetchColumn(),
  'gallery'      => $pdo->query('SELECT COUNT(*) FROM gallery WHERE active=1')->fetchColumn(),
  'testimonials' => $pdo->query('SELECT COUNT(*) FROM testimonials WHERE active=1')->fetchColumn(),
  'bookings'     => $pdo->query("SELECT COUNT(*) FROM bookings WHERE status='pending'")->fetchColumn(),
  'contacts'     => $pdo->query('SELECT COUNT(*) FROM contacts WHERE read_at IS NULL')->fetchColumn(),
];

// Recent bookings
$recent_bookings = $pdo->query('SELECT * FROM bookings ORDER BY created_at DESC LIMIT 5')->fetchAll();

// Recent contacts
$recent_contacts = $pdo->query('SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5')->fetchAll();

require_once 'layout-top.php';
?>

<div class="stats-grid">
  <div class="stat-card">
    <div>
      <div class="stat-num"><?= $stats['services'] ?></div>
      <div class="stat-label">Active Services</div>
    </div>
    <div class="stat-icon">🏢</div>
  </div>
  <div class="stat-card">
    <div>
      <div class="stat-num"><?= $stats['gallery'] ?></div>
      <div class="stat-label">Gallery Images</div>
    </div>
    <div class="stat-icon">🖼️</div>
  </div>
  <div class="stat-card">
    <div>
      <div class="stat-num"><?= $stats['bookings'] ?></div>
      <div class="stat-label">Pending Bookings</div>
    </div>
    <div class="stat-icon">📅</div>
  </div>
  <div class="stat-card">
    <div>
      <div class="stat-num"><?= $stats['contacts'] ?></div>
      <div class="stat-label">Unread Messages</div>
    </div>
    <div class="stat-icon">✉️</div>
  </div>
</div>

<!-- Recent Bookings -->
<div class="card">
  <div class="card-header">
    <h2>Recent Booking Requests</h2>
    <a href="<?= admin_url('bookings.php') ?>" class="btn btn-outline btn-sm">View All</a>
  </div>
  <div>
    <?php if ($recent_bookings): ?>
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Email</th><th>Service</th><th>Date</th><th>Status</th><th>Received</th></tr>
      </thead>
      <tbody>
        <?php foreach ($recent_bookings as $b): ?>
        <tr>
          <td><strong><?= htmlspecialchars($b['name']) ?></strong></td>
          <td><?= htmlspecialchars($b['email']) ?></td>
          <td><?= htmlspecialchars($b['service']) ?></td>
          <td><?= $b['date'] ? date('d M Y', strtotime($b['date'])) : '—' ?></td>
          <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
          <td><?= date('d M, H:i', strtotime($b['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <div style="padding:32px;text-align:center;color:var(--text-muted);">No bookings yet.</div>
    <?php endif; ?>
  </div>
</div>

<!-- Recent Messages -->
<div class="card">
  <div class="card-header">
    <h2>Recent Contact Messages</h2>
    <a href="<?= admin_url('contacts.php') ?>" class="btn btn-outline btn-sm">View All</a>
  </div>
  <div>
    <?php if ($recent_contacts): ?>
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Email</th><th>Subject</th><th>Received</th><th>Status</th></tr>
      </thead>
      <tbody>
        <?php foreach ($recent_contacts as $c): ?>
        <tr>
          <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
          <td><?= htmlspecialchars($c['email']) ?></td>
          <td><?= htmlspecialchars($c['subject'] ?: '(No subject)') ?></td>
          <td><?= date('d M, H:i', strtotime($c['created_at'])) ?></td>
          <td><span class="badge <?= $c['read_at'] ? 'badge-active' : 'badge-pending' ?>"><?= $c['read_at'] ? 'Read' : 'Unread' ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <div style="padding:32px;text-align:center;color:var(--text-muted);">No messages yet.</div>
    <?php endif; ?>
  </div>
</div>

<?php require_once 'layout-bottom.php'; ?>

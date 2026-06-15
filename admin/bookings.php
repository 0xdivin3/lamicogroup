<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';
$admin_page = 'bookings';

$msg = '';
$msg_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'status') {
        $id     = intval($_POST['id']);
        $status = $_POST['status'] ?? 'pending';
        if (in_array($status, ['pending','confirmed','cancelled'])) {
            $pdo->prepare('UPDATE bookings SET status=? WHERE id=?')->execute([$status, $id]);
            $msg = 'Booking status updated.';
        }
    }

    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM bookings WHERE id=?')->execute([intval($_POST['id'])]);
        $msg = 'Booking deleted.';
    }
}

// Filter
$filter = $_GET['status'] ?? 'all';
$where  = ($filter !== 'all') ? "WHERE status = " . $pdo->quote($filter) : '';
$bookings = $pdo->query("SELECT * FROM bookings $where ORDER BY created_at DESC")->fetchAll();

// Counts
$counts = $pdo->query("SELECT status, COUNT(*) as c FROM bookings GROUP BY status")->fetchAll(PDO::FETCH_KEY_PAIR);

require_once 'layout-top.php';
?>

<?php if ($msg): ?>
<div class="alert alert-<?= $msg_type ?>"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<!-- Filter tabs -->
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
  <?php
  $filters = ['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled'];
  foreach ($filters as $key => $label):
    $active = $filter === $key;
  ?>
  <a href="<?= admin_url('bookings.php') ?>?status=<?= $key ?>"
     class="btn <?= $active ? 'btn-primary' : 'btn-outline' ?> btn-sm">
    <?= $label ?>
    <?php if ($key !== 'all' && isset($counts[$key])): ?>
    <span style="background:rgba(255,255,255,.3);padding:1px 7px;border-radius:100px;font-size:.7rem;"><?= $counts[$key] ?></span>
    <?php endif; ?>
  </a>
  <?php endforeach; ?>
</div>

<div class="card">
  <div class="card-header">
    <h2>Bookings (<?= count($bookings) ?>)</h2>
  </div>
  <table class="admin-table">
    <thead>
      <tr><th>Name</th><th>Contact</th><th>Service</th><th>Preferred Date</th><th>Notes</th><th>Status</th><th>Received</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php if ($bookings): foreach ($bookings as $b): ?>
      <tr>
        <td><strong><?= htmlspecialchars($b['name']) ?></strong></td>
        <td>
          <a href="mailto:<?= htmlspecialchars($b['email']) ?>" style="color:var(--gold);"><?= htmlspecialchars($b['email']) ?></a><br>
          <small style="color:var(--text-muted);"><?= htmlspecialchars($b['phone'] ?? '—') ?></small>
        </td>
        <td style="font-size:.82rem;"><?= htmlspecialchars($b['service']) ?></td>
        <td><?= $b['date'] ? date('d M Y', strtotime($b['date'])) : '—' ?></td>
        <td style="max-width:180px;">
          <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;font-size:.8rem;color:var(--slate);">
            <?= htmlspecialchars($b['message'] ?: '—') ?>
          </span>
        </td>
        <td>
          <form method="POST" style="display:inline;">
            <input type="hidden" name="action" value="status">
            <input type="hidden" name="id" value="<?= $b['id'] ?>">
            <select name="status" onchange="this.form.submit()" style="font-size:.78rem;padding:4px 8px;border:1px solid var(--border);border-radius:4px;background:var(--white);">
              <option value="pending"   <?= $b['status']==='pending'   ? 'selected':'' ?>>Pending</option>
              <option value="confirmed" <?= $b['status']==='confirmed' ? 'selected':'' ?>>Confirmed</option>
              <option value="cancelled" <?= $b['status']==='cancelled' ? 'selected':'' ?>>Cancelled</option>
            </select>
          </form>
        </td>
        <td style="font-size:.78rem;color:var(--text-muted);"><?= date('d M Y\nH:i', strtotime($b['created_at'])) ?></td>
        <td>
          <form method="POST" onsubmit="return confirm('Delete this booking?')">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $b['id'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; else: ?>
      <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--text-muted);">No bookings found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require_once 'layout-bottom.php'; ?>

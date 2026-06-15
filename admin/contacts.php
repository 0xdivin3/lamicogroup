<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';
$admin_page = 'contacts';

$msg = '';
$msg_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'mark_read') {
        $pdo->prepare('UPDATE contacts SET read_at=NOW() WHERE id=?')->execute([intval($_POST['id'])]);
        $msg = 'Marked as read.';
    }
    if ($action === 'mark_unread') {
        $pdo->prepare('UPDATE contacts SET read_at=NULL WHERE id=?')->execute([intval($_POST['id'])]);
        $msg = 'Marked as unread.';
    }
    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM contacts WHERE id=?')->execute([intval($_POST['id'])]);
        $msg = 'Message deleted.';
    }
    if ($action === 'mark_all_read') {
        $pdo->exec('UPDATE contacts SET read_at=NOW() WHERE read_at IS NULL');
        $msg = 'All messages marked as read.';
    }
}

// View single message
$viewing = null;
if (isset($_GET['view'])) {
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id=?');
    $stmt->execute([intval($_GET['view'])]);
    $viewing = $stmt->fetch();
    // Auto mark as read
    if ($viewing && !$viewing['read_at']) {
        $pdo->prepare('UPDATE contacts SET read_at=NOW() WHERE id=?')->execute([$viewing['id']]);
        $viewing['read_at'] = date('Y-m-d H:i:s');
    }
}

$contacts = $pdo->query('SELECT * FROM contacts ORDER BY created_at DESC')->fetchAll();
$unread   = $pdo->query('SELECT COUNT(*) FROM contacts WHERE read_at IS NULL')->fetchColumn();

require_once 'layout-top.php';
?>

<?php if ($msg): ?>
<div class="alert alert-<?= $msg_type ?>"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
  <div style="font-size:.9rem;color:var(--text-muted);">
    <?= $unread ?> unread message<?= $unread !== 1 ? 's' : '' ?>
  </div>
  <?php if ($unread > 0): ?>
  <form method="POST">
    <input type="hidden" name="action" value="mark_all_read">
    <button type="submit" class="btn btn-outline btn-sm">✓ Mark All Read</button>
  </form>
  <?php endif; ?>
</div>

<div style="display:grid;grid-template-columns:1fr <?= $viewing ? '1.4fr' : '' ?>;gap:24px;align-items:start;">

  <!-- LIST -->
  <div class="card">
    <div class="card-header">
      <h2>Messages (<?= count($contacts) ?>)</h2>
    </div>
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Subject</th><th>Received</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if ($contacts): foreach ($contacts as $c): ?>
        <tr style="<?= !$c['read_at'] ? 'background:rgba(184,150,62,.04);' : '' ?>">
          <td>
            <strong><?= htmlspecialchars($c['name']) ?></strong><br>
            <a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="font-size:.78rem;color:var(--gold);"><?= htmlspecialchars($c['email']) ?></a>
          </td>
          <td style="font-size:.82rem;"><?= htmlspecialchars($c['subject'] ?: '(No subject)') ?></td>
          <td style="font-size:.78rem;color:var(--text-muted);"><?= date('d M Y, H:i', strtotime($c['created_at'])) ?></td>
          <td><span class="badge <?= $c['read_at'] ? 'badge-active' : 'badge-pending' ?>"><?= $c['read_at'] ? 'Read' : 'Unread' ?></span></td>
          <td>
            <div style="display:flex;gap:4px;">
              <a href="<?= admin_url('contacts.php') ?>?view=<?= $c['id'] ?>" class="btn btn-outline btn-sm">View</a>
              <form method="POST" onsubmit="return confirm('Delete this message?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">No messages yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- MESSAGE VIEW -->
  <?php if ($viewing): ?>
  <div class="card" style="position:sticky;top:80px;">
    <div class="card-header">
      <h2>📧 Message Detail</h2>
      <a href="<?= admin_url('contacts.php') ?>" class="btn btn-outline btn-sm">← Back</a>
    </div>
    <div class="card-body">
      <div style="display:grid;gap:12px;margin-bottom:24px;padding:16px;background:var(--mist);border-radius:8px;font-size:.855rem;">
        <div><strong>From:</strong> <?= htmlspecialchars($viewing['name']) ?></div>
        <div><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($viewing['email']) ?>" style="color:var(--gold);"><?= htmlspecialchars($viewing['email']) ?></a></div>
        <?php if ($viewing['phone']): ?>
        <div><strong>Phone:</strong> <?= htmlspecialchars($viewing['phone']) ?></div>
        <?php endif; ?>
        <div><strong>Subject:</strong> <?= htmlspecialchars($viewing['subject'] ?: '(No subject)') ?></div>
        <div><strong>Received:</strong> <?= date('d M Y, H:i', strtotime($viewing['created_at'])) ?></div>
      </div>

      <div style="padding:20px;background:var(--white);border:1px solid var(--border);border-radius:8px;font-size:.9rem;line-height:1.8;color:var(--slate);white-space:pre-wrap;"><?= htmlspecialchars($viewing['message']) ?></div>

      <div style="display:flex;gap:10px;margin-top:20px;flex-wrap:wrap;">
        <a href="mailto:<?= htmlspecialchars($viewing['email']) ?>?subject=Re: <?= urlencode($viewing['subject'] ?: 'Your Enquiry') ?>" class="btn btn-primary">
          📤 Reply via Email
        </a>
        <form method="POST">
          <input type="hidden" name="action" value="<?= $viewing['read_at'] ? 'mark_unread' : 'mark_read' ?>">
          <input type="hidden" name="id" value="<?= $viewing['id'] ?>">
          <button type="submit" class="btn btn-outline">
            <?= $viewing['read_at'] ? 'Mark Unread' : '✓ Mark Read' ?>
          </button>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>

<?php require_once 'layout-bottom.php'; ?>

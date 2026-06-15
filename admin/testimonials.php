<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';
$admin_page = 'testimonials';

$msg = '';
$msg_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'edit') {
        $client_name = trim(htmlspecialchars($_POST['client_name'] ?? ''));
        $client_role = trim(htmlspecialchars($_POST['client_role'] ?? ''));
        $company     = trim(htmlspecialchars($_POST['company'] ?? ''));
        $message     = trim(htmlspecialchars($_POST['message'] ?? ''));
        $rating      = max(1, min(5, intval($_POST['rating'] ?? 5)));
        $service_id  = intval($_POST['service_id'] ?? 0) ?: null;
        $active      = isset($_POST['active']) ? 1 : 0;

        if (!$client_name || !$message) {
            $msg = 'Client name and message are required.'; $msg_type = 'error';
        } else {
            if ($action === 'add') {
                $stmt = $pdo->prepare('INSERT INTO testimonials (client_name, client_role, company, message, rating, service_id, active) VALUES (?,?,?,?,?,?,?)');
                $stmt->execute([$client_name, $client_role, $company, $message, $rating, $service_id, $active]);
                $msg = 'Testimonial added.';
            } else {
                $id   = intval($_POST['id']);
                $stmt = $pdo->prepare('UPDATE testimonials SET client_name=?, client_role=?, company=?, message=?, rating=?, service_id=?, active=? WHERE id=?');
                $stmt->execute([$client_name, $client_role, $company, $message, $rating, $service_id, $active, $id]);
                $msg = 'Testimonial updated.';
            }
        }
    }

    if ($action === 'delete') {
        $pdo->prepare('DELETE FROM testimonials WHERE id=?')->execute([intval($_POST['id'])]);
        $msg = 'Testimonial deleted.';
    }
}

$services      = $pdo->query('SELECT id, name FROM services WHERE active=1 ORDER BY order_num ASC')->fetchAll();
$testimonials  = $pdo->query('SELECT t.*, s.name as service_name FROM testimonials t LEFT JOIN services s ON t.service_id=s.id ORDER BY t.created_at DESC')->fetchAll();

$editing = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM testimonials WHERE id=?');
    $stmt->execute([intval($_GET['edit'])]);
    $editing = $stmt->fetch();
}

require_once 'layout-top.php';
?>

<?php if ($msg): ?>
<div class="alert alert-<?= $msg_type ?>"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:360px 1fr;gap:24px;align-items:start;">

  <!-- FORM -->
  <div class="card" style="position:sticky;top:80px;">
    <div class="card-header">
      <h2><?= $editing ? '✏️ Edit Testimonial' : '➕ Add Testimonial' ?></h2>
      <?php if ($editing): ?>
      <a href="<?= admin_url('testimonials.php') ?>" class="btn btn-outline btn-sm">Cancel</a>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="action" value="<?= $editing ? 'edit' : 'add' ?>">
        <?php if ($editing): ?><input type="hidden" name="id" value="<?= $editing['id'] ?>"><?php endif; ?>

        <div class="form-group">
          <label>Client Name *</label>
          <input type="text" name="client_name" value="<?= htmlspecialchars($editing['client_name'] ?? '') ?>" placeholder="e.g. David Johnson" required>
        </div>
        <div class="form-grid">
          <div class="form-group">
            <label>Role / Position</label>
            <input type="text" name="client_role" value="<?= htmlspecialchars($editing['client_role'] ?? '') ?>" placeholder="CEO">
          </div>
          <div class="form-group">
            <label>Company</label>
            <input type="text" name="company" value="<?= htmlspecialchars($editing['company'] ?? '') ?>" placeholder="Company Name">
          </div>
        </div>
        <div class="form-group">
          <label>Testimonial Message *</label>
          <textarea name="message" placeholder="What did the client say?"><?= htmlspecialchars($editing['message'] ?? '') ?></textarea>
        </div>
        <div class="form-grid">
          <div class="form-group">
            <label>Star Rating</label>
            <select name="rating">
              <?php for ($i=5;$i>=1;$i--): ?>
              <option value="<?= $i ?>" <?= (intval($editing['rating'] ?? 5) === $i) ? 'selected' : '' ?>>
                <?= str_repeat('★',$i) ?> (<?= $i ?>)
              </option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Related Service</label>
            <select name="service_id">
              <option value="">— General —</option>
              <?php foreach ($services as $svc): ?>
              <option value="<?= $svc['id'] ?>" <?= (intval($editing['service_id'] ?? 0) === $svc['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($svc['name']) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" name="active" <?= (!$editing || $editing['active']) ? 'checked' : '' ?>>
            Show on website
          </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
          <?= $editing ? '💾 Save Changes' : '➕ Add Testimonial' ?>
        </button>
      </form>
    </div>
  </div>

  <!-- LIST -->
  <div class="card">
    <div class="card-header">
      <h2>All Testimonials (<?= count($testimonials) ?>)</h2>
    </div>
    <table class="admin-table">
      <thead>
        <tr><th>Client</th><th>Message</th><th>Rating</th><th>Service</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if ($testimonials): foreach ($testimonials as $t): ?>
        <tr>
          <td>
            <strong><?= htmlspecialchars($t['client_name']) ?></strong><br>
            <small style="color:var(--text-muted);"><?= htmlspecialchars(($t['client_role'] ? $t['client_role'] . ', ' : '') . ($t['company'] ?? '')) ?></small>
          </td>
          <td style="max-width:260px;">
            <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;font-size:.82rem;color:var(--slate);">
              <?= htmlspecialchars($t['message']) ?>
            </span>
          </td>
          <td style="color:var(--gold);letter-spacing:1px;"><?= str_repeat('★', intval($t['rating'])) ?></td>
          <td style="font-size:.82rem;"><?= htmlspecialchars($t['service_name'] ?? '—') ?></td>
          <td><span class="badge <?= $t['active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $t['active'] ? 'Visible' : 'Hidden' ?></span></td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="<?= admin_url('testimonials.php') ?>?edit=<?= $t['id'] ?>" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" onsubmit="return confirm('Delete this testimonial?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--text-muted);">No testimonials yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<?php require_once 'layout-bottom.php'; ?>

<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';
$admin_page = 'services';

$msg = '';
$msg_type = 'success';

// ── HANDLE ACTIONS ──────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'edit') {
        $name       = trim($_POST['name'] ?? '');
        $slug       = trim($_POST['slug'] ?? '');
        $icon       = trim($_POST['icon'] ?? '🏢');
        $short_desc = trim($_POST['short_desc'] ?? '');
        $full_desc  = trim($_POST['full_desc'] ?? '');
        $order_num  = intval($_POST['order_num'] ?? 0);
        $active     = isset($_POST['active']) ? 1 : 0;

        if (!$name || !$slug) {
            $msg = 'Name and slug are required.'; $msg_type = 'error';
        } else {
            if ($action === 'add') {
                $stmt = $pdo->prepare('INSERT INTO services (name, slug, icon, short_desc, full_desc, order_num, active) VALUES (?,?,?,?,?,?,?)');
                $stmt->execute([$name, $slug, $icon, $short_desc, $full_desc, $order_num, $active]);
                $msg = 'Service added successfully.';
            } else {
                $id   = intval($_POST['id']);
                $stmt = $pdo->prepare('UPDATE services SET name=?, slug=?, icon=?, short_desc=?, full_desc=?, order_num=?, active=? WHERE id=?');
                $stmt->execute([$name, $slug, $icon, $short_desc, $full_desc, $order_num, $active, $id]);
                $msg = 'Service updated successfully.';
            }
        }
    }

    if ($action === 'delete') {
        $id = intval($_POST['id']);
        $pdo->prepare('DELETE FROM services WHERE id=?')->execute([$id]);
        $msg = 'Service deleted.';
    }
}

$services = $pdo->query('SELECT * FROM services ORDER BY order_num ASC')->fetchAll();

// Editing?
$editing = null;
if (isset($_GET['edit'])) {
    $editing = $pdo->prepare('SELECT * FROM services WHERE id=?');
    $editing->execute([intval($_GET['edit'])]);
    $editing = $editing->fetch();
}

require_once 'layout-top.php';
?>

<?php if ($msg): ?>
<div class="alert alert-<?= $msg_type ?>"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 1.4fr;gap:24px;align-items:start;">

  <!-- ADD / EDIT FORM -->
  <div class="card">
    <div class="card-header">
      <h2><?= $editing ? '✏️ Edit Service' : '➕ Add New Service' ?></h2>
      <?php if ($editing): ?>
      <a href="<?= admin_url('services.php') ?>" class="btn btn-outline btn-sm">Cancel</a>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="action" value="<?= $editing ? 'edit' : 'add' ?>">
        <?php if ($editing): ?>
        <input type="hidden" name="id" value="<?= $editing['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
          <label>Service Name *</label>
          <input type="text" name="name" value="<?= htmlspecialchars($editing['name'] ?? '') ?>" placeholder="e.g. Gold-Stone Constructions" required>
        </div>
        <div class="form-grid">
          <div class="form-group">
            <label>Slug * <small style="font-weight:400;color:var(--text-muted);">(URL-safe, no spaces)</small></label>
            <input type="text" name="slug" value="<?= htmlspecialchars($editing['slug'] ?? '') ?>" placeholder="construction">
          </div>
          <div class="form-group">
            <label>Icon / Emoji</label>
            <input type="text" name="icon" value="<?= htmlspecialchars($editing['icon'] ?? '🏢') ?>" placeholder="🏗️">
          </div>
        </div>
        <div class="form-group">
          <label>Short Description <small style="font-weight:400;color:var(--text-muted);">(shown on homepage cards)</small></label>
          <textarea name="short_desc" style="min-height:72px;" placeholder="One or two sentences..."><?= htmlspecialchars($editing['short_desc'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
          <label>Full Description <small style="font-weight:400;color:var(--text-muted);">(shown on services page)</small></label>
          <textarea name="full_desc" placeholder="Detailed description..."><?= htmlspecialchars($editing['full_desc'] ?? '') ?></textarea>
        </div>
        <div class="form-grid">
          <div class="form-group">
            <label>Display Order</label>
            <input type="number" name="order_num" value="<?= intval($editing['order_num'] ?? 0) ?>" min="0">
          </div>
          <div class="form-group" style="justify-content:flex-end;padding-bottom:4px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:auto;">
              <input type="checkbox" name="active" <?= (!$editing || $editing['active']) ? 'checked' : '' ?>>
              Active (visible on site)
            </label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
          <?= $editing ? '💾 Save Changes' : '➕ Add Service' ?>
        </button>
      </form>
    </div>
  </div>

  <!-- SERVICES LIST -->
  <div class="card">
    <div class="card-header">
      <h2>All Services (<?= count($services) ?>)</h2>
    </div>
    <table class="admin-table">
      <thead>
        <tr><th>#</th><th>Icon</th><th>Name</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if ($services): foreach ($services as $svc): ?>
        <tr>
          <td style="color:var(--text-muted);"><?= $svc['order_num'] ?></td>
          <td style="font-size:1.3rem;"><?= $svc['icon'] ?></td>
          <td>
            <strong><?= htmlspecialchars($svc['name']) ?></strong><br>
            <small style="color:var(--text-muted);"><?= htmlspecialchars($svc['slug']) ?></small>
          </td>
          <td><span class="badge <?= $svc['active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $svc['active'] ? 'Active' : 'Hidden' ?></span></td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="<?= admin_url('services.php') ?>?edit=<?= $svc['id'] ?>" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" onsubmit="return confirm('Delete this service?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $svc['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--text-muted);">No services yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<?php require_once 'layout-bottom.php'; ?>

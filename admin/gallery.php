<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';
$admin_page = 'gallery';

$msg = '';
$msg_type = 'success';

// Upload directory
$upload_dir = dirname(__DIR__) . '/assets/images/gallery/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// ── HANDLE ACTIONS ──────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'upload') {
        $caption    = trim(htmlspecialchars($_POST['caption'] ?? ''));
        $category   = trim(htmlspecialchars($_POST['category'] ?? 'general'));
        $service_id = intval($_POST['service_id'] ?? 0) ?: null;

        if (empty($_FILES['image']['name'])) {
            $msg = 'Please select an image file.'; $msg_type = 'error';
        } else {
            $file     = $_FILES['image'];
            $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed  = ['jpg','jpeg','png','webp','gif'];

            if (!in_array($ext, $allowed)) {
                $msg = 'Only JPG, PNG, WEBP, or GIF files allowed.'; $msg_type = 'error';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $msg = 'File too large. Maximum 5MB.'; $msg_type = 'error';
            } else {
                $filename = 'img_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
                    $stmt = $pdo->prepare('INSERT INTO gallery (filename, caption, category, service_id) VALUES (?,?,?,?)');
                    $stmt->execute([$filename, $caption, $category, $service_id]);
                    $msg = 'Image uploaded successfully.';
                } else {
                    $msg = 'Upload failed. Check folder permissions.'; $msg_type = 'error';
                }
            }
        }
    }

    if ($action === 'toggle') {
        $id = intval($_POST['id']);
        $pdo->prepare('UPDATE gallery SET active = 1 - active WHERE id=?')->execute([$id]);
        $msg = 'Visibility updated.';
    }

    if ($action === 'delete') {
        $id   = intval($_POST['id']);
        $row  = $pdo->prepare('SELECT filename FROM gallery WHERE id=?');
        $row->execute([$id]);
        $row  = $row->fetch();
        if ($row) {
            @unlink($upload_dir . $row['filename']);
            $pdo->prepare('DELETE FROM gallery WHERE id=?')->execute([$id]);
        }
        $msg = 'Image deleted.';
    }
}

$services = $pdo->query('SELECT id, name FROM services WHERE active=1 ORDER BY order_num ASC')->fetchAll();
$gallery  = $pdo->query('
    SELECT g.*, s.name as service_name
    FROM gallery g
    LEFT JOIN services s ON g.service_id = s.id
    ORDER BY g.created_at DESC
')->fetchAll();

require_once 'layout-top.php';
?>

<?php if ($msg): ?>
<div class="alert alert-<?= $msg_type ?>"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:320px 1fr;gap:24px;align-items:start;">

  <!-- UPLOAD FORM -->
  <div class="card" style="position:sticky;top:80px;">
    <div class="card-header"><h2>📤 Upload Image</h2></div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload">

        <div class="form-group">
          <label>Image File * <small style="font-weight:400;color:var(--text-muted);">(JPG/PNG/WEBP, max 5MB)</small></label>
          <label class="upload-zone" for="image-upload">
            <div style="font-size:2rem;">🖼️</div>
            <p>Click to select image</p>
            <input type="file" id="image-upload" name="image" accept="image/*" required style="display:none;" onchange="previewFile(this)">
          </label>
          <img id="img-preview" src="" alt="" style="display:none;margin-top:10px;border-radius:6px;max-height:140px;width:100%;object-fit:cover;">
        </div>

        <div class="form-group">
          <label>Caption</label>
          <input type="text" name="caption" placeholder="Short description of the image">
        </div>
        <div class="form-group">
          <label>Category</label>
          <input type="text" name="category" placeholder="e.g. construction, media, ict" value="general">
        </div>
        <div class="form-group">
          <label>Link to Service <small style="font-weight:400;color:var(--text-muted);">(optional)</small></label>
          <select name="service_id">
            <option value="">— No specific service —</option>
            <?php foreach ($services as $svc): ?>
            <option value="<?= $svc['id'] ?>"><?= htmlspecialchars($svc['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Upload Image</button>
      </form>
    </div>
  </div>

  <!-- GALLERY LIST -->
  <div class="card">
    <div class="card-header">
      <h2>All Images (<?= count($gallery) ?>)</h2>
    </div>
    <?php if ($gallery): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:16px;padding:20px;">
      <?php foreach ($gallery as $item): ?>
      <div style="border:1px solid var(--border);border-radius:8px;overflow:hidden;background:var(--white);<?= !$item['active'] ? 'opacity:.5;' : '' ?>">
        <img src="<?= site_url('assets/images/gallery/' . htmlspecialchars($item['filename'])) ?>"
             alt="<?= htmlspecialchars($item['caption'] ?? '') ?>"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;"
             onerror="this.style.background='#eee';this.style.minHeight='100px';">
        <div style="padding:10px;">
          <div style="font-size:.78rem;font-weight:600;color:var(--navy);margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
            <?= htmlspecialchars($item['caption'] ?: $item['filename']) ?>
          </div>
          <div style="font-size:.72rem;color:var(--text-muted);margin-bottom:8px;">
            <?= htmlspecialchars($item['category']) ?><?= $item['service_name'] ? ' · ' . htmlspecialchars($item['service_name']) : '' ?>
          </div>
          <div style="display:flex;gap:4px;">
            <form method="POST" style="flex:1;">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-outline btn-sm" style="width:100%;justify-content:center;font-size:.72rem;">
                <?= $item['active'] ? 'Hide' : 'Show' ?>
              </button>
            </form>
            <form method="POST" onsubmit="return confirm('Delete this image permanently?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-danger btn-sm">🗑</button>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="padding:48px;text-align:center;color:var(--text-muted);">
      <div style="font-size:3rem;margin-bottom:12px;">🖼️</div>
      <p>No images uploaded yet. Use the form on the left to get started.</p>
    </div>
    <?php endif; ?>
  </div>

</div>

<script>
function previewFile(input) {
  const preview = document.getElementById('img-preview');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

<?php require_once 'layout-bottom.php'; ?>

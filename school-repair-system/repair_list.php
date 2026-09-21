<?php
require_once 'includes/auth_check.php';
require_once 'config/db.php';
include 'includes/header.php';

$role = $_SESSION['role'];
$userId = $_SESSION['user_id'];

if ($role === 'teacher') {
    $stmt = $pdo->prepare("SELECT r.*, u.fullname as reporter FROM repair_requests r JOIN users u ON r.user_id = u.id WHERE r.user_id = ? ORDER BY r.id DESC");
    $stmt->execute([$userId]);
} elseif ($role === 'technician') {
    $stmt = $pdo->prepare("SELECT r.*, u.fullname as reporter FROM repair_requests r JOIN users u ON r.user_id = u.id WHERE r.assigned_to = ? OR r.status = 'pending' ORDER BY r.id DESC");
    $stmt->execute([$userId]);
} else {
    $stmt = $pdo->query("SELECT r.*, u.fullname as reporter FROM repair_requests r JOIN users u ON r.user_id = u.id ORDER BY r.id DESC");
}
$repairs = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📋 รายการแจ้งซ่อม</h2>
    <?php if ($role === 'admin'): ?>
        <a href="export_csv.php" class="btn btn-outline-secondary">📥 ส่งออก CSV</a>
    <?php endif; ?>
</div>

<div class="table-responsive bg-white p-3 shadow-sm rounded">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>รหัสใบแจ้ง</th>
                <th>ผู้แจ้ง</th>
                <th>สถานที่</th>
                <th>ประเภท</th>
                <th>ความเร่งด่วน</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repairs as $row): ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['request_no']); ?></strong></td>
                <td><?= htmlspecialchars($row['reporter']); ?></td>
                <td><?= htmlspecialchars($row['building'] . ' ' . $row['room']); ?></td>
                <td><?= ucfirst($row['problem_type']); ?></td>
                <td><span class="badge bg-warning text-dark"><?= $row['urgency']; ?></span></td>
                <td><span class="badge bg-primary"><?= $row['status']; ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
<?php
require_once 'includes/auth_check.php';
require_once 'config/db.php';
include 'includes/header.php';

$stmt = $pdo->query("
    SELECT 
        COUNT(*) AS total_count,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_count,
        SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) AS progress_count,
        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_count
    FROM repair_requests
");
$stats = $stmt->fetch();
?>

<h2 class="mb-4">📊 Dashboard สรุปภาพรวมระบบ</h2>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 text-center">
            <h5>งานทั้งหมด</h5>
            <h2 class="fw-bold"><?= $stats['total_count']; ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark p-3 text-center">
            <h5>รอดำเนินการ</h5>
            <h2 class="fw-bold"><?= $stats['pending_count']; ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white p-3 text-center">
            <h5>กำลังดำเนินการ</h5>
            <h2 class="fw-bold"><?= $stats['progress_count']; ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white p-3 text-center">
            <h5>ซ่อมเสร็จแล้ว</h5>
            <h2 class="fw-bold"><?= $stats['completed_count']; ?></h2>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="repair_list.php" class="btn btn-outline-primary">📋 ดูรายการแจ้งซ่อมทั้งหมด</a>
    <?php if ($_SESSION['role'] === 'teacher' || $_SESSION['role'] === 'admin'): ?>
        <a href="repair_add.php" class="btn btn-success">+ สร้างใบแจ้งซ่อมใหม่</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
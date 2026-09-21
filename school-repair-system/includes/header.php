<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งซ่อมภายในโรงเรียน</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; font-family: 'Sarabun', sans-serif; }
    </style>
</head>
<body>
<?php if (isset($_SESSION['user_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🔧 ระบบแจ้งซ่อมโรงเรียน</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="repair_list.php">รายการแจ้งซ่อม</a></li>
                <?php if ($_SESSION['role'] === 'teacher' || $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link text-white" href="repair_add.php">แจ้งซ่อมใหม่</a></li>
                <?php endif; ?>
            </ul>
            <div class="d-flex text-white align-items-center gap-3">
                <span>👤 <?= htmlspecialchars($_SESSION['fullname']); ?> (<?= ucfirst($_SESSION['role']); ?>)</span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>
<div class="container pb-5">
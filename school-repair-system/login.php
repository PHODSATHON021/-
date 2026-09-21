<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

include 'includes/header.php';
?>


<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">🔑 เข้าสู่ระบบแจ้งซ่อม</h4>
            </div>
            <div class="card-body">
                <form action="login_process.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้ใช้งาน (Username)</label>
                        <input type="text" name="username" class="form-control" required placeholder="admin / teacher1 / tech1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">รหัสผ่าน (Password)</label>
                        <input type="password" name="password" class="form-control" required placeholder="123456">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
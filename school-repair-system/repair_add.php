<?php
require_once 'includes/auth_check.php';
checkRole(['teacher', 'admin']);
require_once 'config/db.php';

function generateRequestNo(PDO $pdo): string {
    $prefix = 'RP-' . date('Ym') . '-';
    $stmt = $pdo->prepare("SELECT request_no FROM repair_requests WHERE request_no LIKE :prefix ORDER BY id DESC LIMIT 1");
    $stmt->execute(['prefix' => $prefix . '%']);
    $lastRecord = $stmt->fetch();
    $nextNum = $lastRecord ? ((int)substr($lastRecord['request_no'], -3)) + 1 : 1;
    return $prefix . str_pad((string)$nextNum, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestNo = generateRequestNo($pdo);
    $userId = $_SESSION['user_id'];
    $building = trim($_POST['building']);
    $room = trim($_POST['room']);
    $problemType = $_POST['problem_type'];
    $urgency = $_POST['urgency'];
    $description = trim($_POST['description']);

    $stmt = $pdo->prepare("INSERT INTO repair_requests (request_no, user_id, building, room, problem_type, urgency, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$requestNo, $userId, $building, $room, $problemType, $urgency, $description]);
    $repairId = $pdo->lastInsertId();

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFilename = uniqid('img_', true) . '.' . strtolower($ext);
        $targetPath = 'uploads/' . $newFilename;
        
        if (!is_dir('uploads')) { mkdir('uploads', 0755, true); }
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $stmtImg = $pdo->prepare("INSERT INTO repair_images (repair_id, image_type, image_path) VALUES (?, 'before', ?)");
            $stmtImg->execute([$repairId, $targetPath]);
        }
    }

    $_SESSION['flash_message'] = "ส่งใบแจ้งซ่อมเรียบร้อยแล้ว (รหัส: $requestNo)";
    $_SESSION['flash_type'] = "success";
    header("Location: repair_list.php");
    exit;
}

include 'includes/header.php';
?>

<div class="card shadow col-md-8 mx-auto">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">📝 แบบฟอร์มแจ้งซ่อมอุปกรณ์</h4>
    </div>
    <div class="card-body">
        <form action="repair_add.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">อาคารสถานที่ *</label>
                <input type="text" name="building" class="form-control" required placeholder="เช่น อาคารเรียน 1">
            </div>
            <div class="mb-3">
                <label class="form-label">เลขห้อง / บริเวณที่เกิดปัญหา *</label>
                <input type="text" name="room" class="form-control" required placeholder="เช่น ห้อง 303">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">ประเภทปัญหา *</label>
                    <select name="problem_type" class="form-select" required>
                        <option value="electrical">ไฟฟ้า / หลอดไฟ</option>
                        <option value="aircon">เครื่องปรับอากาศ</option>
                        <option value="computer">คอมพิวเตอร์ / เครือข่าย</option>
                        <option value="furniture">ครุภัณฑ์ / โต๊ะเก้าอี้</option>
                        <option value="other">อื่นๆ</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ระดับความเร่งด่วน *</label>
                    <select name="urgency" class="form-select" required>
                        <option value="low">ปกติ</option>
                        <option value="medium" selected>ปานกลาง</option>
                        <option value="high">ด่วนที่สุด</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">รายละเอียดปัญหา *</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">รูปภาพประกอบก่อนซ่อม</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success w-100">บันทึกแจ้งซ่อม</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
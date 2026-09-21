<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

function checkRole(array $allowedRoles): void {
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        http_response_code(403);
        echo "<h2 style='color:red; text-align:center; margin-top:50px;'>403 Forbidden - คุณไม่มีสิทธิ์เข้าถึงหน้านี้</h2>";
        exit;
    }
}
?>
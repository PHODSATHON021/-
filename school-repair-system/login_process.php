<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        $_SESSION['flash_message'] = "ยินดีต้อนรับคุณ " . $user['fullname'];
        $_SESSION['flash_type'] = "success";
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['flash_message'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        $_SESSION['flash_type'] = "error";
        header("Location: login.php");
        exit;
    }
}
?>
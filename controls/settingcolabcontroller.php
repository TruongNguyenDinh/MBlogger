<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

// 🔒 Ngăn in ra rác hoặc warning
ob_start();
header('Content-Type: application/json; charset=utf-8');

class Settingcolabcontroller {
    private $userService;

    public function __construct() {
        $conn = Database::getConnection();
        $this->userService = new UserService($conn);
    }

    public function gitStatus() {
        // Kiểm tra đăng nhập
        $id = $_SESSION['user']['id'];
        $userInfo = $this->userService->getUserById($id);
    }
}

$controller = new Settingcolabcontroller();
$controller->gitStatus();
// 🧹 Xóa mọi output rác (PHP warning chẳng hạn)
ob_end_flush();
exit;
?>

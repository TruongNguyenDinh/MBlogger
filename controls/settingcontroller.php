<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

// 🔒 Ngăn in ra rác hoặc warning
ob_start();
header('Content-Type: application/json; charset=utf-8');

class SettingController {
    private $userService;

    public function __construct() {
        $conn = Database::getConnection();
        $this->userService = new UserService($conn);
    }

    public function updateAccount() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        // Chỉ nhận POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        // Lấy dữ liệu
        $id = $_SESSION['user']['id'];
        $fullname = trim($_POST['fullname'] ?? '');
        $birthday = trim($_POST['birthday'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $work = trim($_POST['work'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = trim($_POST['role'] ?? 'person');
        $address = trim($_POST['address'] ?? '');

        // ⚙️ Gọi service update
        $result = $this->userService->updateUser(
            $id, $fullname, $email, $phone, $birthday, $work, $role, $address );

        // Trả JSON
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}

$controller = new SettingController();
$controller->updateAccount();
// 🧹 Xóa mọi output rác (PHP warning chẳng hạn)
ob_end_flush();
exit;
?>

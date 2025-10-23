<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

// Bắt output buffer ngay lập tức để ngăn lỗi headers
ob_start();
header('Content-Type: application/json; charset=utf-8');

class SettingController {
    private $userService;

    public function __construct() {
        $conn = Database::getConnection();
        $this->userService = new UserService($conn);
    }

    public function updateAccount() {
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $id = $_SESSION['user']['id'];
        $fullname = trim($_POST['fullname'] ?? '');
        $birthday = trim($_POST['birthday'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $work = trim($_POST['work'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = trim($_POST['role'] ?? 'person');
        $address = trim($_POST['address'] ?? '');

        $result = $this->userService->updateUser(
            $id, $fullname, $email, $phone, $birthday, $work, $role, $address
        );
        if ($result['success']) {
            // Lấy lại dữ liệu user mới nhất từ DB
            $updatedUser = $this->userService->getUserById($id);

            // Nếu là object thì chuyển sang mảng chỉ lấy các trường cần
            if ($updatedUser) {
                $_SESSION['user'] = [
                    'id' => $updatedUser->getId(),
                    'fullname' => $updatedUser->getName(),
                    'role' => $updatedUser->getRole(),
                    'email' => $updatedUser->getEmail(),
                    'phone' => $updatedUser->getPhone(),
                    'work' => $updatedUser->getWork(),
                    'address' => $updatedUser->getAddress(),
                    'birthday' => $updatedUser->getBirthday()
                ];
            }
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    public function changeAvatar(){
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $id = $_SESSION['user']['id'];
        
    }
}
$controller = new SettingController();
$controller->updateAccount();

// Xóa output rác và kết thúc script
ob_end_flush();
exit;

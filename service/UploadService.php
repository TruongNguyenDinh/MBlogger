<?php
// login.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class UploadService {
    public static function uploadImgNews($file) {
        $userId = $_SESSION['user']['id'];

        // Tạo thư mục đích: uploads/{userId}
        $folder = "/uploads/$userId/news/";
        $targetDir = __DIR__ . "../../.." . $folder;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Tạo tên file ngẫu nhiên
        $fileName = uniqid() . "_" . basename($file['name']);
        $targetFile = $targetDir . $fileName;

        // Di chuyển file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $folder . $fileName; // đường dẫn để lưu DB
        } else {
            throw new Exception("Không thể upload file!");
        }
    }
    public static function uploadImgAvt($file) {
        if (!isset($_SESSION['user']['id'])) {
            throw new Exception("Chưa đăng nhập!");
        }

        $userId = $_SESSION['user']['id'];
        $folder = "/uploads/$userId/avatar/";
        $targetDir = __DIR__ . "/.." . $folder;

        // Tạo thư mục nếu chưa có
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Đường dẫn file ảnh avatar mới
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = "avatar." . $extension; // luôn tên avatar.[đuôi file]
        $targetFile = $targetDir . $fileName;

        // 🔥 Xóa avatar cũ nếu có
        foreach (glob($targetDir . "avatar.*") as $oldFile) {
            unlink($oldFile);
        }
        // Di chuyển file upload vào thư mục đích
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $folder . $fileName; // đường dẫn tương đối để lưu DB
        } else {
            throw new Exception("Không thể upload file!");
        }
    }
}
?>

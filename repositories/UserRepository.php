<?php
require_once __DIR__ . '/../mappers/UserMapper.php';

class UserRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function findByUsername(string $username): ?User {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return UserMapper::map($row);
    }
    public function isExistedEmail(string $email): ?User {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return UserMapper::map($row);
    }
    public function newUser(User $user){
        $stmt = $this->conn->prepare("
            INSERT INTO users (username, url_avt, password_hash, fullname, email)
            VALUES (:username, :url_avt, :password_hash, :fullname, :email)
        ");
        $stmt->execute([
            ':username' => $user->getUsername(),  // hoặc getUsername() nếu có
            ':password_hash' => $user->getPasswordHash(),
            ':fullname' => $user->getName(),
            ':email' => $user->getEmail(),
            ':url_avt' => $user->getUrl()
        ]);
    }
    public function findById($id): ?User {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return UserMapper::map($row); // trả về object User
    }
    // infomation for article
    public function findUserInfoById(int $id): ?array {
        $stmt = $this->conn->prepare("
            SELECT fullname, url_avt 
            FROM users 
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null; // không có user nào

        return $row; // trả về mảng ['fullname' => ..., 'url_avt' => ...]
    }
    public function updateUser($id, $fullname, $birthday, $email, $uwork, $phone, $role, $address) {
        $stmt = $this->conn->prepare("
            UPDATE users 
            SET fullname = ?, birthday = ?, email = ?, uwork = ?, phone = ?, role = ?, address = ?
            WHERE id = ?
        ");
        return $stmt->execute([$fullname, $birthday, $email, $uwork, $phone, $role, $address, $id]);
    }


}
?>

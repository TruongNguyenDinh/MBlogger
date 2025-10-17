<?php
require_once __DIR__ . '/../repositories/UserRepository.php';

class UserService {
    private $userRepo;

    public function __construct($conn) {
        $this->userRepo = new UserRepository($conn);
    }

    public function checkLogin($username, $password) {
        $user = $this->userRepo->findByUsername($username);
        if (!$user) {
            return ['success' => false, 'message' => 'Tài khoản không tồn tại'];
        }

        if (!password_verify($password, $user->getPasswordHash())) {
            return ['success' => false, 'message' => 'Sai mật khẩu'];
        }
        return ['success' => true, 'user' => $user];
    }
    public function checkRegister($username,$password,$email){
        $user = $this->userRepo->findByUsername($username);
        $cemail = $this->userRepo->isExistedEmail($email);
        
        if($user){
            return ['success'=>false,'message'=>"Tài khoản đã tồn tại"];
        }
        if($cemail){
            return ['success'=>false, 'message'=>"Email này đã tồn tại trong hệ thống"];
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $url_avt = "../../uploads/default/avatar1.svg";
        $user = new User([
            'username' =>$username,
            'url_avt' => $url_avt,
            'fullname' => $username,
            'email' => $email,
            'password_hash' => $hash,
        ]);
        $this->userRepo->newUser($user);
        return ['success' => true, 'message' => 'Đăng ký thành công!'];
    }  
    public function getUserById($id): ?User {
        return $this->userRepo->findById($id);
    }
    public function updateUser($id, $fullname, $email, $phone, $birthday, $work, $role, $address) {
        // Kiểm tra ID
            if (!$id) {
                return ['status' => false, 'message' => 'Không xác định được người dùng.'];
            }

            // Kiểm tra rỗng
            if (empty($fullname) || empty($birthday) || empty($email) || empty($work) || empty($phone) || empty($address)) {
                return ['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin.'];
            }
            // 🔹 Kiểm tra role hợp lệ
            $validRoles = ['person', 'company', 'employer'];
            if (!in_array(strtolower($role), $validRoles)) {
                return ['success' => false, 'message' => 'Role không hợp lệ. Chỉ được: person, company hoặc employer.'];
            }

            // 3️⃣ Kiểm tra số điện thoại (chỉ chứa số)
            if (!preg_match('/^[0-9]+$/', $phone)) {
                return ['success' => false, 'message' => 'Phone number must contain only digits.'];
            }

            // Kiểm tra định dạng email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Lỗi định dang email.'];
            }

            // Gọi service cập nhật (bạn thay bằng hàm thật của mình)
            
            $success = $this->userRepo->updateUser($id, $fullname, $birthday, $email, $work, $phone, $role, $address);
            if ($success) {
                return ['success' => true, 'message' => 'Cập nhật tài khoản thành công.'];
            } else {
                return ['success' => false, 'message' => 'Cập nhật thất bại, vui lòng thử lại.'];
            }
    }
    public function changeStatus($id,$status){
        return $this->userRepo->changeStatus($id,$status);
    }

}
?>

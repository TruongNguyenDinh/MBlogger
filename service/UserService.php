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
}
?>

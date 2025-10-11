<?php
class User {
    private $id;
    private $url_avt;
    private $username;
    private $fullname;
    private $birthday;
    private $address;
    private $work;
    private $phone;
    private $email;
    private $role;
    private $create_at;
    private $github_status;
    private $password_hash;

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            // Nếu tồn tại property, tự động gán
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // --------- Setters ----------
    public function setName(string $newName): void { $this->fullname = $newName; }
    public function setBirthday(string $newBirthday): void { $this->birthday = $newBirthday; }
    public function setAddress(string $newAddress): void { $this->address = $newAddress; }
    public function setWork(string $newWork): void { $this->work = $newWork; }
    public function setEmail(string $newEmail): void { $this->email = $newEmail; }
    public function setPhone(string $newPhone): void { $this->phone = $newPhone; }
    public function setGithubStatus(string $newGhs): void { $this->github_status = $newGhs; }
    public function setRole(string $newRole): void { $this->role = $newRole; }

    // --------- Getters ----------
    public function getId() { return $this->id; }
    public function getUsername(){ return $this->username; }
    public function getName() { return $this->fullname; }
    public function getBirthday() { return $this->birthday; }
    public function getAddress(){ return $this->address; }
    public function getWork(){ return $this->work; }
    public function getEmail() { return $this->email; }
    public function getPhone(){ return $this->phone; }
    public function getAvatar(){ return $this->url_avt; }
    public function getRole() { return $this->role; }
    public function getGithubStatus() { return $this->github_status; }
    public function getCreatedAt(){ return $this->create_at; }
    public function getUrl() { return $this->url_avt; }
    public function getPasswordHash() { return $this->password_hash;}
}
?>

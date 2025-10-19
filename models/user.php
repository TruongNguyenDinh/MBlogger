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
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // --------- Setters ----------
    public function setName(string $newName): void { $this->fullname = $newName; }
    public function setBirthday(?string $newBirthday): void { $this->birthday = $newBirthday; }
    public function setAddress(?string $newAddress): void { $this->address = $newAddress; }
    public function setWork(?string $newWork): void { $this->work = $newWork; }
    public function setEmail(?string $newEmail): void { $this->email = $newEmail; }
    public function setPhone(?string $newPhone): void { $this->phone = $newPhone; }
    public function setGithubStatus(?string $newGhs): void { $this->github_status = $newGhs; }
    public function setRole(string $newRole): void { $this->role = $newRole; }

    // --------- Getters ----------
    public function getId(): mixed { return $this->id; }
    public function getUsername(): mixed { return $this->username; }
    public function getName(): string { return $this->fullname ?? 'N/A'; }
    public function getBirthday(): string { return $this->birthday ?? 'N/A'; }
    public function getAddress(): string { return $this->address ?? 'N/A'; }
    public function getWork(): string { return $this->work ?? 'N/A'; }
    public function getEmail(): string { return $this->email ?? 'N/A'; }
    public function getPhone(): string { return $this->phone ?? 'N/A'; }
    public function getAvatar(): mixed { return $this->url_avt; }
    public function getRole(): string { return $this->role ?? 'person'; }
    public function getGithubStatus(): string { return $this->github_status ?? ''; }
    public function getCreatedAt(): mixed { return $this->create_at; }
    public function getUrl(): mixed { return $this->url_avt; }
    public function getPasswordHash(): mixed { return $this->password_hash; }
}
?>

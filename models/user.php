<?php
class User {
    private $id, $fullname, $birthday, $address, $work, $email, $phone;

    // Constructor
    public function __construct($fullname, $birthday, $address, $work, $email, $phone) {
        $this->fullname = $fullname;
        $this->birthday = $birthday;
        $this->address = $address;
        $this->work = $work;
        $this->email = $email;
        $this->phone = $phone;
    }

    // Setter
    public function setID($id) { $this->id = $id; }
    public function setName($newName) { $this->fullname = $newName; }
    public function setBirthday($newBirthday) { $this->birthday = $newBirthday; }
    public function setAddress($newAddress) { $this->address = $newAddress; }
    public function setWork($newWork) { $this->work = $newWork; }
    public function setEmail($newEmail) { $this->email = $newEmail; }
    public function setPhone($newPhone) { $this->phone = $newPhone; }

    // Getter
    public function getID() { return $this->id; }
    public function getName() { return $this->fullname; }
    public function getBirthday() { return $this->birthday; }
    public function getAddress() { return $this->address; }
    public function getWork() { return $this->work; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
}
?>

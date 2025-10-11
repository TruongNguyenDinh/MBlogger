<?php
require_once __DIR__ . '/../models/user.php';

class UserMapper {
    public static function map(array $row): User {
        return new User([
            'id' => $row['id'],
            'url_avt' => $row['url_avt'],
            'fullname' => $row['fullname'],
            'birthday' => $row['birthday'] ?? null,
            'address' => $row['address'] ?? null,
            'work' => $row['uwork'],
            'phone' => $row['phone'] ?? null,
            'email' => $row['email'],
            'role' => $row['role'],
            'create_at' => $row['created_at'],
            'github_status' => $row['github_status'],
            'password_hash' => $row['password_hash']
        ]);
    }
}
?>

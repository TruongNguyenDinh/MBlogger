<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/UserService.php';

header('Content-Type: application/json');

$email = $_POST['email'] ?? "";
$confirm_code = $_POST['confirm-code'] ?? "Trống";
var_dump($email);
var_dump($confirm_code);
$conn = Database::getConnection();
$service = new UserService($conn);

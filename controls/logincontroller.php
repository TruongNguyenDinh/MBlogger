<?php
session_start();
// user tĩnh test
$valid_user = "admin";
$valid_pass = "123";

$username = $_POST['username'] ?? '';
$password = $_POST['pass'] ?? '';

// Lấy base path của dự án
$basePath = '/mblogger/views';  // dự án nằm trong folder memoriesflow

if($username === $valid_user && $password === $valid_pass){
    $_SESSION['user_id'] = $username;
    header("Location: $basePath/home/home.php"); // redirect đúng
    exit;
} else {
    $_SESSION['error'] = "Sai tài khoản hoặc mật khẩu";
    header("Location: $basePath/form/form.php");
    exit;
}
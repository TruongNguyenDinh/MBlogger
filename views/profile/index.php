<?php
$basePath = '/mblogger/views';
// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: $basePath/form/form.php");
    exit;
}
else{
    header("Location: $basePath/profile/profile.php");
}
?>
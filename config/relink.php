<?php
require_once __DIR__.'/./config.php';
$client_id = GITHUB_CLIENT_ID;
$redirect_uri = GITHUB_REDIRECT_URI;
$state = bin2hex(random_bytes(8)); // tạo chuỗi ngẫu nhiên

$_SESSION['oauth_state'] = $state; // lưu lại để xác minh sau

// chỉ xin quyền đọc thông tin công khai
$url = "https://github.com/login/oauth/authorize?" . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'scope' => 'read:user read:public_repo',
    'state' => $state
]);
?>

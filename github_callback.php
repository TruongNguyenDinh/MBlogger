<?php
require_once './config/config.php';
require_once './config/db.php';
require_once './service/GithubService.php';
require_once './service/UserService.php';
if (!isset($_GET['code'])) {
    die('Không có mã code từ GitHub.');
}

$code = $_GET['code'];

// --- Bước 1: Lấy access token ---
$url = "https://github.com/login/oauth/access_token";
$data = [
    'client_id' => GITHUB_CLIENT_ID,
    'client_secret' => GITHUB_CLIENT_SECRET,
    'code' => $code,
    'redirect_uri' => GITHUB_REDIRECT_URI
];
$options = [
    'http' => [
        'header' => "Accept: application/json\r\nContent-Type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ]
];
$response = file_get_contents($url, false, stream_context_create($options));
if ($response === FALSE) die('Không thể kết nối tới GitHub.');

$result = json_decode($response, true);
if (!isset($result['access_token'])) die('Không nhận được access token.');

$access_token = $result['access_token'];

// --- Bước 2: Lấy thông tin user ---
$user_info = file_get_contents("https://api.github.com/user", false, stream_context_create([
    'http' => [
        'header' => "User-Agent: MyApp\r\nAuthorization: token $access_token\r\n"
    ]
]));

$user = json_decode($user_info, true);

// $user['login'] là username
$link_github = isset($user['login']) ? "https://github.com/{$user['login']}" : '';

session_start();
if (!isset($_SESSION['user']['id'])) {
    die('Bạn cần đăng nhập trước khi liên kết GitHub.');
}
$user_id = $_SESSION['user']['id'];
// --- Bước 3: Gọi service để lưu thông tin ---
$conn = Database::getConnection();
$githubService = new GithubService($conn);
$userService = new UserService($conn);
$github = new Github([
    'id' => $user['id'],
    'user_id' => $user_id,
    'github_username' => $user['login'],
    'access_token' => $access_token,
    'link_github' => "https://github.com/".$user['login'], // <-- đúng
    'token_type' => $result['token_type'] ?? '',
    'linked_at' => date('Y-m-d H:i:s')
]);
$githubService->saveGithubInfo($github);
$userService->changeStatus($user_id,1);

// --- Lưu session ---
$_SESSION['github_user'] = $user;
$_SESSION['github_token'] = $access_token;

header('Location: views/setting/setting.php?page=colab');
exit;
?>

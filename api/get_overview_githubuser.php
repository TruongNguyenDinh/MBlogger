<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/GithubService.php';

$conn = Database::getConnection();
$githubService = new GithubService($conn);

// Lấy userId từ query hoặc session
$userId = $_GET['user_id'] ?? ($_SESSION['user']['id'] ?? null);
if (!$userId) {
    http_response_code(400);
    echo json_encode(["error" => "Missing user_id"]);
    exit;
}

// Lấy thông tin GitHub của người dùng trong DB
$github = $githubService->getGithubInfoByUserId($userId);
if (!$github) {
    echo json_encode([
        "hasGithub" => false,
        "public_repos" => 0,
        "stars" => 0
    ]);
    exit;
}

$githubUsername = $github->getGithubUsername();
if (!$githubUsername) {
    echo json_encode([
        "hasGithub" => false,
        "public_repos" => 0,
        "stars" => 0
    ]);
    exit;
}
$githubToken = $github->getAccessToken();

// Nếu có GitHub username hợp lệ thì mới gọi API
$path = "https://api.github.com/users/" . $githubUsername;
$result = $githubService->OverviewUser($path,$githubToken );
$result['stars'] = $githubService->countStars($githubUsername,$githubToken );
$result['hasGithub'] = true;

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../service/GithubService.php';

header('Content-Type: application/json');

$service = new GithubService(Database::getConnection());
$userId = $_SESSION['user']['id'];
$github = $service->getGithubInfoByUserId($userId);

echo json_encode([
  'username' => $github->getGithubUsername(),
  'token' => $github->getAccessToken(),
]);

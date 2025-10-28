<?php
/*

*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/GithubService.php';

header('Content-Type: application/json');

try {
    $conn = Database::getConnection();
    $service = new GithubService($conn);

    // Get query on url (if any)
    $query = $_GET['query'] ?? 'user_reference';
    // Identify the user to retrieve
    if ($query === 'user_reference') { // This is owner
        $userId = $_SESSION['user']['id'];
    } else {
        $userId = intval($query); // query for other id
    }

    // Get GitHub infomation from userID
    $github = $service->getGithubInfoByUserId($userId);

    if ($github) {
        echo json_encode([
            'username' => $github->getGithubUsername(),
            'token' => $github->getAccessToken(),
            'link_github' => $github->getLink(),
        ]);
    } else {
        echo json_encode([
            'username' => null,
            'token' => null,
            'link_github' =>null
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        'username' => null,
        'token' => null,
        'link_github' =>null,
    ]);
}

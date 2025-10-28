<?php
if (!$showLoginPopup) {
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/RepoService.php';

$conn = Database::getConnection();
$repoService = new RepoService($conn);
$userId = $_SESSION['user']['id'];
$repos = $repoService->getReposByUserId($userId);

if (!$repos) {
    echo "<tr><td colspan='6'>Unable to load data</td></tr>";
    exit;
}

foreach ($repos as $r) {
    echo "
    <tr 
        data-repo='{$r->name}' 
        data-branch='{$r->branch}' 
        data-repoid='{$r->id}'
    >
        <td>{$r->name}</td>
        <td>{$r->latest_commit}</td>
        <td>⭐ {$r->stars}</td>
        <td>{$r->branch}</td>
        <td>0</td>
        <td>{$r->id}</td>
    </tr>
    ";
}
}

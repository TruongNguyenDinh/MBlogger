<?php
$username = "TruongNguyenDinh";
// $toke here
$url = "https://api.github.com/users/$username/repos";

// --- Gọi API lấy danh sách repo ---
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT => 'PHP Script',
    CURLOPT_HTTPHEADER => [
        "Authorization: token $token",
        "Accept: application/vnd.github.v3+json"
    ]
]);
$response = curl_exec($ch);
curl_close($ch);

$repos = json_decode($response, true);

if (!$repos || isset($repos['message'])) {
    echo "<tr><td colspan='6'>Không tải được dữ liệu: " . ($repos['message'] ?? 'Không rõ lỗi') . "</td></tr>";
    exit;
}

// --- Duyệt qua từng repo ---
foreach ($repos as $repo) {
    $repoName = htmlspecialchars($repo['name']);
    $stars = $repo['stargazers_count'];
    $branch = htmlspecialchars($repo['default_branch']);
    $repoId = $repo['id'];
    $repoUrl = htmlspecialchars($repo['html_url']);

    // --- Lấy commit mới nhất ---
    $commitUrl = "https://api.github.com/repos/$username/$repoName/commits?sha=$branch&per_page=1";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $commitUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'PHP Script',
        CURLOPT_HTTPHEADER => [
            "Authorization: token $token",
            "Accept: application/vnd.github.v3+json"
        ]
    ]);
    $commitResponse = curl_exec($ch);
    curl_close($ch);

    $commitData = json_decode($commitResponse, true);
    $latestCommit = isset($commitData[0]['commit']['message'])
        ? htmlspecialchars($commitData[0]['commit']['message'])
        : "No commits";

    echo "
    <tr data-repo='$repoName' data-branch='$branch'>
        <td>$repoName</td>
        <td>$latestCommit</td>
        <td>⭐ $stars</td>
        <td>$branch</td>
        <td>0</td>
        <td>$repoId</td>
    </tr>
    ";
}
?>

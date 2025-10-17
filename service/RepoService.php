<?php
require_once __DIR__ . '/GithubService.php';

class RepoService {
    private $conn;
    private $githubService;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->githubService = new GithubService($conn);
    }

    // Hàm lấy danh sách repo từ GitHub API
    public function getReposByUserId($userId) {
        $info = $this->githubService->getGithubInfoByUserId($userId);
        if (!$info) return null;

        $username = $info->getGithubUsername();
        $token = $info->getAccessToken();

        $url = "https://api.github.com/users/$username/repos";
        $repos = $this->callGithubAPI($url, $token);

        if (!$repos || isset($repos['message'])) {
            return null;
        }

        // Trả về dạng đối tượng thay vì mảng
        $repoList = [];
        foreach ($repos as $repo) {
            $obj = new stdClass();
            $obj->id = $repo['id'];
            $obj->name = $repo['name'];
            $obj->stars = $repo['stargazers_count'];
            $obj->branch = $repo['default_branch'];
            $obj->url = $repo['html_url'];

            // Lấy commit mới nhất
            $commitUrl = "https://api.github.com/repos/$username/{$repo['name']}/commits?sha={$repo['default_branch']}&per_page=1";
            $commitData = $this->callGithubAPI($commitUrl, $token);
            $obj->latest_commit = isset($commitData[0]['commit']['message'])
                ? $commitData[0]['commit']['message']
                : "No commits";

            $repoList[] = $obj;
        }

        return $repoList;
    }

    // Hàm gọi GitHub API (chung cho các endpoint)
    private function callGithubAPI($url, $token) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'MBlogger App',
            CURLOPT_HTTPHEADER => [
                "Authorization: token $token",
                "Accept: application/vnd.github.v3+json"
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}

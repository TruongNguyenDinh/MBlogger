<?php
require_once __DIR__ . '/GithubService.php';
require_once __DIR__.'/../repositories/RepoRepository.php';

class RepoService {
    private $conn;
    private $githubService;
    private $repoRepo;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->githubService = new GithubService($conn);
        $this->repoRepo = new RepoRepository($conn);
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
    public function addRepo($userID, $repo_name, $branch, $repo_url) {
        // Kiểm tra dữ liệu đầu vào
        if (empty($userID) || empty($repo_name) || empty($branch) || empty($repo_url)) {
            return [
                "status" => "error",
                "message" => "Missing required data."
            ];
        }
        // Gọi xuống Repository để thêm repo
        $success = $this->repoRepo->insertNewRepo($userID, $repo_name, $branch, $repo_url);
        if ($success) {
            return [
                "status" => "success",
                "message" => "New repo added successfully.",
                "repo" => [
                    "user_id" => $userID,
                    "repo_name" => $repo_name,
                    "branch" => $branch,
                    "repo_url" => $repo_url
                ]
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unable to add repo to database."
            ];
        }
    }

}

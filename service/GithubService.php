<?php
require_once __DIR__ . '/../repositories/GithubRepository.php';

class GithubService {
    private $githubRepo;

    public function __construct($conn) {
        $this->githubRepo = new GithubRepository($conn);
    }

    /**
     * Lưu thông tin GitHub vào CSDL
     */
    public function saveGithubInfo(Github $github): array{
        // ✅ Kiểm tra dữ liệu cơ bản
        if (empty($github->getUserId()) || empty($github->getGithubUsername()) || empty($github->getAccessToken())) {
            return [
                'success' => false,
                'message' => 'Thiếu thông tin bắt buộc (user_id, username hoặc token).'
            ];
        }
        // ✅ Gọi repo để lưu thông tin
        $saved = $this->githubRepo->saveGithubInfo($github);
        if ($saved) {
            return [
                'success' => true,
                'message' => 'Lưu thông tin GitHub thành công.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Không thể lưu thông tin GitHub vào cơ sở dữ liệu.'
            ];
        }
    }
    public function getGithubInfoByUserId(int $userId): ?Github {
        // ✅ Kiểm tra đầu vào
        if (empty($userId)) {
            return null;
        }

        // ✅ Lấy dữ liệu từ repo
        $github = $this->githubRepo->findGithubByUserId($userId);

        // ❌ Không tìm thấy
        if (!$github) {
            return null;
        }

        // ✅ Trả về đối tượng Github
        return $github;
    }

    public function OverviewUser($path, $token = null) {
        $ch = curl_init($path);

        $headers = [
            'User-Agent: MBlogger',
            'Accept: application/vnd.github+json'
        ];

        if ($token) {
            $headers[] = 'Authorization: token ' . $token;
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $err = curl_error($ch);
            curl_close($ch);
            return ['error' => $err];
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status !== 200) {
            return ['error' => "GitHub API returned status $status"];
        }

        $data = json_decode($response, true);
        return $data ?: ['error' => 'Invalid JSON response'];
    }

    public function countStars($username, $token = null) {
        $url = "https://api.github.com/users/$username/repos?per_page=100";
        $ch = curl_init($url);

        $headers = [
            'User-Agent: MBlogger',
            'Accept: application/vnd.github+json'
        ];

        if ($token) {
            $headers[] = 'Authorization: token ' . $token;
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $repos = json_decode($response, true);
        if (!is_array($repos)) return 0;

        $totalStars = 0;
        foreach ($repos as $repo) {
            $totalStars += $repo['stargazers_count'] ?? 0;
        }
        return $totalStars;
    }




}

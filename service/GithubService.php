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

}

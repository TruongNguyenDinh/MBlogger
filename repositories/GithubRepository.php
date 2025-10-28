<?php 
require_once __DIR__.'/../mappers/GithubMapper.php';

class GithubRepository{
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function saveGithubInfo(Github $github): bool {
        try {
            // Kiểm tra xem GitHub ID đã tồn tại chưa
            $stmt = $this->conn->prepare("SELECT 1 FROM github_accounts WHERE id = :id");
            $stmt->execute([':id' => $github->getId()]);
            $exists = $stmt->fetchColumn();

            if ($exists) {
                // Nếu đã tồn tại thì UPDATE
                $stmt = $this->conn->prepare("
                    UPDATE github_accounts 
                    SET user_id = :user_id,
                        github_username = :github_username,
                        access_token = :access_token,
                        link_github = :link_github,
                        token_type = :token_type,
                        linked_at = :linked_at
                    WHERE id = :id
                ");
                return $stmt->execute([
                    ':id' => $github->getId(),
                    ':user_id' => $github->getUserId(),
                    ':github_username' => $github->getGithubUsername(),
                    ':access_token' => $github->getAccessToken(),
                    ':link_github' => $github->getLink(),
                    ':token_type' => $github->getTokenType(),
                    ':linked_at' => $github->getLinkedAt()
                ]);
            } else {
                // Nếu chưa tồn tại thì INSERT
                $stmt = $this->conn->prepare("
                    INSERT INTO github_accounts 
                        (id, user_id, github_username, access_token, link_github, token_type, linked_at)
                    VALUES 
                        (:id, :user_id, :github_username, :access_token, :link_github, :token_type, :linked_at)
                ");
                return $stmt->execute([
                    ':id' => $github->getId(),
                    ':user_id' => $github->getUserId(),
                    ':github_username' => $github->getGithubUsername(),
                    ':access_token' => $github->getAccessToken(),
                    ':link_github' => $github->getLink(),
                    ':token_type' => $github->getTokenType(),
                    ':linked_at' => $github->getLinkedAt()
                ]);
            }
        } catch (PDOException $e) {
            error_log("❌ Lỗi lưu Github info: " . $e->getMessage());
            return false;
        }
    }

    public function findGithubByUserId(int $userId): ?Github {
        $stmt = $this->conn->prepare("
            SELECT id, github_username, access_token, linked_at, link_github
            FROM github_accounts
            WHERE user_id = :user_id
            LIMIT 1
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }
        // 🔧 Tạo đối tượng Github từ dữ liệu
        $github = new Github();
        $github->setId($row['id']);
        $github->setGithubUsername($row['github_username']);
        $github->setAccessToken($row['access_token']);
        $github->setLinkedAt($row['linked_at']);
        $github->setLink($row['link_github']);
        return $github;
    }


}
?>
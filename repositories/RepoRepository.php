<?php
    require_once __DIR__.'/../mappers/RepoMapper.php';

    class RepoRepository{
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        //
        public function findRepoById(int $id): ?Repo{
            $stmt = $this->conn->prepare("SELECT * FROM repos WHERE id = :id LIMIT 1");
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row) return null;
            return RepoMapper::map($row);
        }

        public function insertNewRepo($userID, $repo_name, $branch, $repo_url) {
            $stmt = $this->conn->prepare("
                INSERT INTO repos (user_id, repo_name, branch, repo_url)
                VALUES (:user_id, :repo_name, :branch, :repo_url)
            ");

            $stmt->bindParam(':user_id', $userID);
            $stmt->bindParam(':repo_name', $repo_name);
            $stmt->bindParam(':branch', $branch);
            $stmt->bindParam(':repo_url', $repo_url);

            if ($stmt->execute()) {
                // ✅ Lấy ID vừa thêm
                return $this->conn->lastInsertId();
            }

            return false;
        }


    }
?>
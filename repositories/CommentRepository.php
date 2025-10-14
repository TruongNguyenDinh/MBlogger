<?php
    require_once __DIR__ .'/../mappers/CommentMapper.php';
    class CommentRepository{
        private $conn;
        public function __construct($conn){
            $this->conn = $conn;
        }

        public function findCommentByArticleID($id): array{
            $stmt = $this->conn->prepare("
                SELECT * FROM comments
                WHERE article_id = :id
            ");
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
            $comments = [];
            
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row){
                $comments[]= CommentMapper::map($row);
            }
            return $comments;
        }
        public function addComment($article_id, $user_comment_id, $content) {
            try {
                $stmt = $this->conn->prepare("
                    INSERT INTO comments (article_id, user_comment_id, content, created_at)
                    VALUES (:article_id, :user_comment_id, :content, NOW())
                ");
                $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
                $stmt->bindParam(':user_comment_id', $user_comment_id, PDO::PARAM_INT);
                $stmt->bindParam(':content', $content, PDO::PARAM_STR);

                return $stmt->execute(); // true nếu thêm thành công
            } catch (PDOException $e) {
                error_log("Add comment failed: " . $e->getMessage());
                return false;
            }
        }

    }
?>
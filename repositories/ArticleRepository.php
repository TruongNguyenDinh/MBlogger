<?php
 require_once __DIR__.'/../mappers/ArticleMapper.php';

 class ArticleRepository{
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    // Bài đăng của người dùng
    public function findArticleByUserID(int $id): array{
        $stmt = $this->conn->prepare("SELECT * FROM articles WHERE user_id = :id");
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();

        $articles = [];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Map từng hàng thành object Article
        foreach($rows as $row){
            $articles[]= ArticleMapper::map($row);
        }
        return $articles;
    }
    //Load bài đăng
    public function findArticleById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // World
    public function findLatestArticles(int $limit = 10) {
        $stmt = $this->conn->prepare("
            SELECT * 
            FROM articles 
            ORDER BY created_at DESC 
            LIMIT :limit
        ");

        // Ép kiểu an toàn trước khi bind
        $limit = (int)$limit;
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $articles = [];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $articles[] = ArticleMapper::map($row);
        }

        return $articles;
    }
 }
?>
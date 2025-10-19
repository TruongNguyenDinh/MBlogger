<?php

class TopicRepository{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function insertTopicWithNews($topic, $newsID) {
        $stmt = $this->conn->prepare("
            INSERT INTO topics (topic_name, news_id)
            VALUES (:topic, :news_id)
            ON DUPLICATE KEY UPDATE news_id = :news_id
        ");

        return $stmt->execute([
            ':topic' => $topic,
            ':news_id' => $newsID
        ]);
    }

    public function insertTopicWithArticle($topic, $articleId) {
        $stmt = $this->conn->prepare("
            INSERT INTO topics (topic_name, article_id)
            VALUES (:topic, :article_id)
            ON DUPLICATE KEY UPDATE article_id = :article_id
        ");

        return $stmt->execute([
            ':topic' => $topic,
            ':article_id' => $articleId
        ]);
    }
    
    public function findWithTopic(string $topic): array {
        try {
            $stmt = $this->conn->prepare("
                SELECT article_id, news_id
                FROM topics
                WHERE topic_name = :topic
            ");
            $stmt->execute([':topic' => $topic]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $rows = [
                'article-id' => [],
                'news-id' => []
            ];

            foreach ($results as $row) {
                if (!is_null($row['article_id'])) {
                    $rows['article-id'][] = $row['article_id'];
                }
                if (!is_null($row['news_id'])) {
                    $rows['news-id'][] = $row['news_id'];
                }
            }

            // Loại bỏ trùng lặp nếu cần
            $rows['article-id'] = array_unique($rows['article-id']);
            $rows['news-id'] = array_unique($rows['news-id']);

            return $rows;

        } catch (PDOException $e) {
            return [
                'article-id' => [],
                'news-id' => []
            ];
        }
    }


}
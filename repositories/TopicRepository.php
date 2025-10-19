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


}
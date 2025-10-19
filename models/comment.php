<?php
class Comment {
    private $id;
    private $article_id;
    private $user_comment_id;
    private $content;
    private $created_at;

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // --- Getters ---
    public function getId() {
        return $this->id;
    }

    public function getArticleId() {
        return $this->article_id;
    }

    public function getUserCommentId() {
        return $this->user_comment_id;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // --- Setters ---
    public function setId($id) {
        $this->id = $id;
    }

    public function setArticleId($article_id) {
        $this->article_id = $article_id;
    }

    public function setUserCommentId($user_comment_id) {
        $this->user_comment_id = $user_comment_id;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}
?>

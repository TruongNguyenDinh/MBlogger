<?php
class Article {
    private $id;
    private $user_id;
    private $repo_id;
    private $title;
    private $content;
    private $acomment;
    private $created_at;

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value; 
            }
        }
    }

    // ====== GETTERS ======
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getRepoId() {
        return $this->repo_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getComments() {
        return $this->acomment;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // ====== SETTERS ======
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setRepoId($repo_id) {
        $this->repo_id = $repo_id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}
?>

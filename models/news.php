<?php
class News {
    private $id;
    private $title;
    private $topic;
    private $content;
    private $thumbnail;
    private $author_id;
    private $created_at;

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // ===== Getter =====
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getTopic() {
        return $this->topic;
    }

    public function getContent() {
        return $this->content;
    }

    public function getThumbnail() {
        return $this->thumbnail;
    }

    public function getAuthorId() {
        return $this->author_id;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // ===== Setter =====
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setTopic($topic) {
        $this->topic = $topic;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    public function setAuthorId($author_id) {
        $this->author_id = $author_id;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}
?>

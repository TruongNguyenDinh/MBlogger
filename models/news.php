<?php
class News {
    private
    $id, $banner, $author, $date, $title, $content;

    public function __construct($id, $banner, $author, $date, $title, $content) {
        $this->id = $id;
        $this->banner = $banner;
        $this->author = $author;
        $this->date = $date;
        $this->title = $title;
        $this->content = $content;
    }

    // ===== Getter =====
    public function getId() {
        return $this->id;
    }

    public function getBanner() {
        return $this->banner;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getDate() {
        return $this->date;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }
}
?>

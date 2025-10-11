<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../service/ArticleService.php';
$conn = Database::getConnection();
class HomeController {
    private $articleService;

    public function __construct() {
        $conn = Database::getConnection();
        $this->articleService = new ArticleService($conn);
    }

    public function getArticles() {
        return $this->articleService->worldArti();
    }
}

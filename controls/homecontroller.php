<?php
require_once __DIR__ . '/../config/db.php';         // ⚠️ PHẢI GỌI TRƯỚC để có class Database
require_once __DIR__ . '/../service/ArticleService.php';

class HomeController {
    private $articleService;

    public function __construct($conn) {
        $this->articleService = new ArticleService($conn);
    }

    public function renderHome():array {
        $results = $this->articleService->worldArti();

        // Debug kiểm tra dữ liệu
        // var_dump($results);

        // Truyền biến sang view
        $data = ['results' => $results];
        return $data;
    }
}

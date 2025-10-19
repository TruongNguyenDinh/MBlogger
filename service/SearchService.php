<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/ArticleService.php';
require_once __DIR__.'/UserService.php';
require_once __DIR__.'/TopicService.php';
require_once __DIR__.'/NewsService.php';
require_once __DIR__.'/../repositories/TopicRepository.php';

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$query = trim($data['query'] ?? '');

$conn = Database::getConnection();
$topicService = new TopicService($conn);
$userService = new UserService($conn);
$articleService = new ArticleService($conn);
$newsService = new NewsService($conn);
$topicRepo = new TopicRepository($conn);

$newsResult = [];
$articleResult = [];
$userResult = [];

if ($query !== '') {
    if (is_numeric($query)) {
        $news = $newsService->getNewsService($query);
        if ($news) $newsResult[] = $news['title'];

        $article = $articleService->findArticleById($query);
        if ($article) $articleResult[] = $article['title'];
        
        $user = $userService->getUserById($query);
        if ($user) {
        $userResult[] = [
            'name' => $user->getName(),
            'avatar' => $user->getUrl() // hoặc đúng tên getter trong class User
        ];
}

    } else {
        $tmp = strtolower($topicService->removeVietnameseAccentsString($query));
        $rows = $topicRepo->findWithTopic($tmp);

        $newIds = $rows['news-id'] ?? [];
        $articleIds = $rows['article-id'] ?? [];
        $userIds = $rows['user-id'] ?? [];

        foreach ($newIds as $newId) {
            $news = $newsService->getNewsService($newId);
            if ($news) $newsResult[] = $news['title'];
        }

        foreach ($articleIds as $articleId) {
            $article = $articleService->findArticleById($articleId);
            if ($article) $articleResult[] = $article['title'];
        }

        foreach ($userIds as $userId) {
            $user = $userService->getUserById($userId);
            if ($user) $userResult[] = $user->getName();
        }
    }
}

// Trả về JSON
echo json_encode([
    'users' => $userResult,
    'articles' => $articleResult,
    'news' => $newsResult
]);

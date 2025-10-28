<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
        if ($news) {
            $newsResult[] = [
                'id' => $news['id'] ?? $query,
                'title' => $news['title']
            ];
        }

        $article = $articleService->findArticleById($query);
        if ($article) {
            $articleResult[] = [
                'id' => $article['id'] ?? $query,
                'title' => $article['title']
            ];
        }
        
        $user = $userService->getUserById($query);
        if ($user) {
            $userResult[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'avatar' => $user->getUrl() // hoặc đúng getter avatar
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
            if ($news) {
                $newsResult[] = [
                    'id' => $newId,
                    'title' => $news['title']
                ];
            }
        }

        foreach ($articleIds as $articleId) {
            $article = $articleService->findArticleById($articleId);
            if ($article) {
                $articleResult[] = [
                    'id' => $articleId,
                    'title' => $article['title']
                ];
            }
        }

        foreach ($userIds as $userId) {
            $user = $userService->getUserById($userId);
            if ($user) {
                $userResult[] = [
                    'id' => $userId,
                    'name' => $user->getName(),
                    'avatar' => $user->getUrl()
                ];
            }
        }
    }
}

echo json_encode([
    'users' => $userResult,
    'articles' => $articleResult,
    'news' => $newsResult
]);

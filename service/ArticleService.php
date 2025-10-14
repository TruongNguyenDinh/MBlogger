<?php
    require_once __DIR__.'/../repositories/ArticleRepository.php';
     require_once __DIR__.'/../repositories/UserRepository.php';
     require_once __DIR__.'/../repositories/RepoRepository.php';
    require_once __DIR__.'/../repositories/CommentRepository.php';
    class ArticleService{
        private $articleRepo;
        private $userRepo;
        private $repoRepo;
        private $commentRepo;
        public function __construct($conn){
            $this->articleRepo = new ArticleRepository($conn);
            $this->userRepo = new UserRepository($conn);
            $this->repoRepo = new RepoRepository($conn);
            $this->commentRepo = new CommentRepository($conn);
        }

        public function indiviDualArti($id){
            $articles = $this->articleRepo->findArticleByUserID($id);
            $result = [];
            foreach ($articles as $article) {
                    // Lấy thông tin user
                    $userInfo = $this->userRepo->findUserInfoById($article->getUserId());
                    // Lấy thông tin repo
                    $repoInfo = $this->repoRepo->findRepoById($article->getRepoId());
                    // Lấy thông tin comment
                    $commentRepo = $this->commentRepo->findCommentByArticleID($article->getId());
                    $commentCount = count($commentRepo);
                    // Gom dữ liệu lại

                    $result[] = [
                        "id" => $article->getId(),
                        "username" => $userInfo ? $userInfo['fullname'] : 'Unknown',
                        "url_avt" => $userInfo ? $userInfo['url_avt'] : null,
                        "repo" => $repoInfo ? $repoInfo->getRepoName() : 'Unknown',
                        "branch" => $repoInfo ? $repoInfo->getBranch() : 'main',
                        "title" => $article->getTitle(),
                        "content" => $article->getContent(),
                        "acomment"=>$commentCount
                    ];
                }
            return $result;
        }
        public function worldArti(): array {
            // Lấy 10 bài đăng mới nhất
            $articles = $this->articleRepo->findLatestArticles();
                $result = [];
                foreach ($articles as $article) {
                    // Lấy thông tin user
                    $userInfo = $this->userRepo->findUserInfoById($article->getUserId());
                    // Lấy thông tin repo
                    $repoInfo = $this->repoRepo->findRepoById($article->getRepoId());
                    // Lấy thông tin comment
                    $commentRepo = $this->commentRepo->findCommentByArticleID($article->getId());
                    $commentCount = count($commentRepo);
                    // Gom dữ liệu lại
                    $result[] = [
                        "id" => $article->getId(),
                        "username" => $userInfo ? $userInfo['fullname'] : 'Unknown',
                        "url_avt" => $userInfo ? $userInfo['url_avt'] : null,
                        "repo" => $repoInfo ? $repoInfo->getRepoName() : 'Unknown',
                        "branch" => $repoInfo ? $repoInfo->getBranch() : 'main',
                        "title" => $article->getTitle(),
                        "content" => $article->getContent(),
                        "acomment"=>$commentCount
                    ];
                }
            return $result;
        }
        public function findArticleById($articleId){
            return $this->articleRepo->findArticleById($articleId);
        }
    }
?>
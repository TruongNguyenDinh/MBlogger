<?php
    require_once __DIR__.'/../repositories/ArticleRepository.php';
     require_once __DIR__.'/../repositories/UserRepository.php';
     require_once __DIR__.'/../repositories/RepoRepository.php';
    
    class ArticleService{
        private $articleRepo;
        private $userRepo;
        private $repoRepo;
        public function __construct($conn){
            $this->articleRepo = new ArticleRepository($conn);
            $this->userRepo = new UserRepository($conn);
            $this->repoRepo = new RepoRepository($conn);
        }

        public function indiviDualArti($id){

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
                    // Gom dữ liệu lại
                    $result[] = [
                        "id" => $article->getId(),
                        "username" => $userInfo ? $userInfo['fullname'] : 'Unknown',
                        "url_avt" => $userInfo ? $userInfo['url_avt'] : null,
                        "repo" => $repoInfo ? $repoInfo->getRepoName() : 'Unknown',
                        "branch" => $repoInfo ? $repoInfo->getBranch() : 'main',
                        "title" => $article->getTitle(),
                        "content" => $article->getContent(),
                        "acomment"=>$article->getComments()
                    ];
                }
            return $result;
        }
    }
?>
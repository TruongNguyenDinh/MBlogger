<?php
    require_once __DIR__ .'/../repositories/NewsRepository.php';
    require_once __DIR__ .'/../repositories/UserRepository.php';
    class NewsService{
        private $newsRepo;
        private $userRepo;

        public function __construct($conn){
            $this->newsRepo = new NewsRepository($conn);
            $this->userRepo = new UserRepository($conn);
        }

        public function getNews(): array{
            $the_news = $this->newsRepo->getNewsFromDB();
            $result = [];
            foreach($the_news as $news){
                $userInfo = $this->userRepo->findUserInfoById($news->getAuthorId());

                $result[]=[
                    'id'=>$news->getId(),
                    'author'=>$userInfo['fullname'],
                    'title'=>$news->getTitle(),
                    'created_at'=>$news->getCreatedAt(),
                    'content'=>$news->getContent(),
                    'thumbnail'=>$news->getThumbnail()
                ];
            }
            return $result;
        }
        public function createNews($title, $topic, $content, $thumbnail, $author_id) {
            // 1️⃣ Kiểm tra đầu vào
            if (empty(trim($title)) || empty(trim($content))) {
                return [
                    'success' => false,
                    'message' => 'Tiêu đề và nội dung không được để trống.'
                ];
            }

            // 2️⃣ Nếu chưa có ảnh, dùng mặc định
            if (empty($thumbnail)) {
                $thumbnail = "../../uploads/default/avatar1.svg";
            }
            // 3️⃣ Gọi repository để lưu
            $result = $this->newsRepo->saveNews($title, $topic, $content, $thumbnail, $author_id);
            return $result;
        }
    }
?>
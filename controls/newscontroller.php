<?php
    require_once __DIR__ .'/../config/db.php';
    require_once __DIR__ .'/../service/NewsService.php';

    class Newscontroller{
        private $newsService;

        public function __construct(){
            $conn = Database::getConnection();
            $this->newsService = new NewsService($conn);
        }

        public function getThumbnail(): array{
            $thumbnails = $this->newsService->getNews();
            $result = [];
            foreach($thumbnails as $thumbnail){
                $result[] = [
                'data_id'=> $thumbnail['id'],
                'thumbnail'=>$thumbnail['thumbnail']
                ]; 
            }
            return $result;
        }
        public function getDetail(): array{
            $details = $this->newsService->getNews();
            $result = [];
            foreach($details as $detail){
                $result[]=[
                    'id'=>$detail['id'],
                    'author'=>$detail['author'],
                    'created_at'=>$detail['created_at'],
                    'title'=>$detail['title'],
                    'content'=>$detail['content']
                ];
            }
            return $result;
        }
    }
?>
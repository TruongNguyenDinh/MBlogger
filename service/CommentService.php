<?php
    require_once __DIR__ .'/../repositories/CommentRepository.php';
    require_once __DIR__ .'/../repositories/UserRepository.php';
    class CommentService{
        private $userRepo;
        private $commentRepo;

        public function __construct($conn){
            $this->userRepo = new UserRepository($conn);
            $this->commentRepo = new CommentRepository($conn);
        }

        public function getComments($article_id):array{
            $comments = $this->commentRepo->findCommentByArticleID($article_id);
            $result = [];
            foreach($comments as $comment){
                $userInfo = $this->userRepo->findUserInfoById($comment->getUserCommentId());
                $result[]= [
                    'fullname'=>$userInfo['fullname'],
                    'url_avt'=>$userInfo? $userInfo['url_avt'] : null,
                    'content'=>$comment->getContent(),
                    'created_at' => date('d/m/Y', strtotime($comment->getCreatedAt())),
                ];
            }
            return $result;
        }
        public function addCommentService($user_comment_id, $article_id, $content) {
            // Kiểm tra dữ liệu đầu vào
            if (empty($content)) {
                return ['success' => false, 'message' => 'Comment cannot be blank'];
            }

            // Gọi repository để thêm comment
            $result = $this->commentRepo->addComment($article_id, $user_comment_id, $content);

            if ($result) {
                return ['success' => true, 'message' => 'Comment has been added'];
            } else {
                return ['success' => false, 'message' => 'Add comment failed'];
            }
        }

    }
?>
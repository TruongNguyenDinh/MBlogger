<?php
    require_once __DIR__.'/../mappers/NewsMapper.php';
    class NewsRepository{
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        public function getNewsFromDB(int $limit = 10){
                    $stmt = $this->conn->prepare("
                        SELECT *
                        FROM news
                        ORDER BY created_at DESC
                        LIMIT :limit
                    ");
                // ép kiểu an toàn trước khi bind
                $limit = (int)$limit;
                $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);
                $stmt->execute();
                
                $news = [];
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($rows as $row){
                    $news[] = NewsMapper::map($row);
                }

                return $news;
                }
                public function saveNews($title, $topic, $content, $thumbnail, $author_id) {
            try {
                $sql = "INSERT INTO news (title, topic, content, thumbnail, author_id)
                        VALUES (?, ?, ?, ?, ?)";

                $stmt = $this->conn->prepare($sql);

                if (!$stmt) {
                    throw new Exception("Prepare failed");
                }

                // ⚠️ PDO không dùng bind_param — chỉ cần execute với mảng tham số
                $stmt->execute([$title, $topic, $content, $thumbnail, $author_id]);

                // ✅ Lấy ID vừa insert
                $id = $this->conn->lastInsertId();

                return [
                    'success' => true,
                    'message' => 'Tin tức đã được lưu thành công!',
                    'id' => $id
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Lỗi khi lưu tin tức: ' . $e->getMessage()
                ];
            }
        }
    }
?>
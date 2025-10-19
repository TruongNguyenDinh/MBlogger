<?php
    require_once __DIR__.'/../models/news.php';
    class NewsMapper{
        public static function map(array $rows):News{
            return new News([
                'id'=>$rows['id'],
                'title'=>$rows['title'],
                'topic'=>$rows['topic'],
                'content'=>$rows['content'],
                'thumbnail'=>$rows['thumbnail'],
                'author_id'=>$rows['author_id'],
                'created_at'=>$rows['created_at']
            ]);
        }
    }
?>
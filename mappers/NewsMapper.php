<?php
    require_once __DIR__.'/../models/news.php';
    class NewsMapper{
        public static function map(array $row):News{
            return new News([
                'id'=>$row['id'],
                'title'=>$row['title'],
                'topic'=>$row['topic'],
                'content'=>$row['content'],
                'thumbnail'=>$row['thumbnail'],
                'author_id'=>$row['author_id'],
                'created_at'=>$row['created_at']
            ]);
        }
    }
?>
<?php
    require_once __DIR__.'/../models/article.php';
    class ArticleMapper{
        public static function map(array $row):Article{
            return new Article([
                'id'=> $row['id'],
                'user_id'=> $row['user_id'],
                'repo_id'=> $row['repo_id'],
                'title'=> $row['title'],
                'content'=>$row['content'],
                'acomment'=> $row['acomment'],
                'created_at'=> $row['created_at']
            ]);
        }
    }
?>
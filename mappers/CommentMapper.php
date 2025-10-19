<?php
 require_once __DIR__.'/../models/comment.php';
 class CommentMapper{
    public static function map(array $rows):Comment{
        return new Comment([
            'id'=>$rows['id'],
            'article_id'=>$rows['article_id'],
            'user_comment_id'=>$rows['user_comment_id'],
            'content'=>$rows['content'],
            'created_at'=>$rows['created_at']
        ]);
    }
 }
?>
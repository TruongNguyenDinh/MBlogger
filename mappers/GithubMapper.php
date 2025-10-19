<?php 
    require_once __DIR__.'/../models/github.php';
    class GithubMapper{
        public static function map(array $rows):Github{
            return new Github([
                'id'=>$rows['id'],
                'user_id'=>$rows['user_id'],
                'github_username'=>$rows['github_username'],
                'access_token'=>$rows['access_token'],
                'link_github'=>$rows['link_github'],
                'token_type'=>$rows['token_type'],
                'linked_at'=>$rows['linked_at']
            ]);
        }
    }
?>
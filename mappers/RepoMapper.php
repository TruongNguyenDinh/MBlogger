<?php
 require_once __DIR__.'/../models/repo.php';

 class RepoMapper{
    public static function map(array $row): Repo{
        return new Repo([
            'id'=>$row['id'],
            'user_id'=>$row['user_id'],
            'repo_name'=>$row['repo_name'],
            'branch'=>$row['branch'],
            'repo_url'=>$row['repo_url']
        ]);
    }
 }
?>
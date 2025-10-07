<?php
    class Article{
        private
        $avt,$userName,$repoName,$branchName,$id,$content,$comments,$title;
        public function __construct($id,$userName,$title,$repoName,$branchName,$content,$comments,$avt){
            $this->id = $id;
            $this->title = $title;
            $this->userName = $userName;
            $this->repoName = $repoName;
            $this->branchName = $branchName;
            $this->content = $content;
            $this->comments = $comments;
            $this->avt = $avt;
        }
        // Setter
        public function setContent($newContent){
            $this->content = $newContent;
        }
        // Getter
        public function getContent(){return $this->content;}
    }
?>
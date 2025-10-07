<?php 
    class Github{
        private
        $github_name,$repo,$star,$activity;
        public function __construct($github_name,$repo,$star,$activity){
            $this->github_name = $github_name;
            $this->repo = $repo;
            $this->star = $star;
            $this->activity = $activity;
        }

        public function getGhn(){return $this->github_name;}
        public function getRepo() {return $this->repo;}
        public function getStar(){return $this->star;}
        public function getAct(){return $this->activity;}
    }
?>
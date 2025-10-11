<?php
    require_once __DIR__.'/../mappers/RepoMapper.php';

    class RepoRepository{
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        //
        public function findRepoById(int $id): ?Repo{
            $stmt = $this->conn->prepare("SELECT * FROM repos WHERE id = :id LIMIT 1");
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row) return null;
            return RepoMapper::map($row);
        }
    }
?>
<?php
class Repo {
    private $id;
    private $user_id;
    private $repo_name;
    private $branch;
    private $stars;
    private $lastest_commit;
    private $repo_url;

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // ===== GETTERS =====
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getRepoName() {
        return $this->repo_name;
    }

    public function getBranch() {
        return $this->branch;
    }

    public function getStars() {
        return $this->stars;
    }

    public function getLastestCommit() {
        return $this->lastest_commit;
    }

    public function getRepoUrl() {
        return $this->repo_url;
    }

    // ===== SETTERS =====
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setRepoName($repo_name) {
        $this->repo_name = $repo_name;
    }

    public function setBranch($branch) {
        $this->branch = $branch;
    }

    public function setStars($stars) {
        $this->stars = $stars;
    }

    public function setLastestCommit($lastest_commit) {
        $this->lastest_commit = $lastest_commit;
    }

    public function setRepoUrl($repo_url) {
        $this->repo_url = $repo_url;
    }
}
?>

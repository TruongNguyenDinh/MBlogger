<?php 
class Github {
    private  $id ;
    private $user_id ;
    private $github_username ;
    private $access_token;
    private  $link_github ;
    private  $token_type;
    private $linked_at;

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // --- Getters ---
    public function getId(): ?int {
        return $this->id;
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function getGithubUsername(): ?string {
        return $this->github_username;
    }

    public function getAccessToken(): ?string {
        return $this->access_token;
    }

    public function getLink(): ?string {
        return $this->link_github;
    }

    public function getTokenType(): ?string {
        return $this->token_type;
    }

    public function getLinkedAt(): ?string {
        return $this->linked_at;
    }

    // --- Setters ---
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }

    public function setGithubUsername(string $github_username): void {
        $this->github_username = $github_username;
    }

    public function setAccessToken(string $access_token): void {
        $this->access_token = $access_token;
    }

    public function setLink(string $link_github): void {
        $this->link_github = $link_github;
    }

    public function setTokenType(string $token_type): void {
        $this->token_type = $token_type;
    }

    public function setLinkedAt(string $linked_at): void {
        $this->linked_at = $linked_at;
    }
}
?>

<?php
// Giả lập dữ liệu bài viết (sau này thay bằng DB)
$articles = [
    [
        "id" => 1,
        "username" => "Nguyễn Đình Trường",
        "repo" => "student_management_CPP",
        "branch" => "main",
        "title" => "This is a simple project for learning cpp language.",
        "content" => "Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet,
            consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
        "comment" => 100
    ],
    [
        "id" => 2,
        "username" => "Alice",
        "repo" => "AI_chatbot",
        "branch" => "dev",
        "title" => "Building a chatbot using PHP and JS.",
        "content" => "This is a demo article about chatbot project...",
        "comment" => 45
    ]
];
?>

<link rel="stylesheet" href="../../assets/css/article.css">

<?php foreach ($articles as $article): ?>
<div class="container-post">
    <div class="article-header">
        <div class="article-user_info">
            <div class="user-avt"></div>
            <div class="username"><?php echo ($article["username"]); ?></div>
        </div>
        <div class="source-repo">Repo: <?php echo ($article["repo"]); ?></div>
        <div class="source-branch">Branch: <?php echo ($article["branch"]); ?></div>
        <div class="btn-open">Open</div>
        <div class="article-id">ID: <?php echo $article["id"]; ?></div>
    </div>
    <div class="article-title">
        <?php echo ($article["title"]); ?>
    </div>
    <div class="article-content">
        <?php echo (htmlspecialchars($article["content"])); ?>
    </div>
    <button class="toggle-btn">Show more</button>
    <div class="article-comment" data-id="<?php echo $article["id"]; ?>">
        Comment: <?php echo $article["comment"]; ?>
    </div>
</div>
<?php endforeach; ?>

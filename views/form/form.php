<?php
session_start(); // 💡 Quan trọng — phải có trước khi dùng $_SESSION
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memories Flow</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/form.css">
    <link rel="stylesheet" href="../../assets/css/notification.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div id="notification-area"></div>
    <?php if (!empty($_SESSION['error'])): ?>
        <?php include '../notification/error/notiform.php'; ?>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <header>
        <div class="menu">
            <h1>MBlogger</h1>
            <ul>
                <li><a href="#">info</a></li>
                <li><a href="#">about us</a></li>
                <li><a href="#">support</a></li>
                <li id="search_icon"><i class="fa-solid fa-magnifying-glass"></i></li>
            </ul>
            <div class="search-group">
                <input type="text" class="form_search" id="form_search"
                       name="form_search" placeholder="Search..." list="suggestions">
                <div id="suggestions" class="suggestions"></div>
            </div>  
        </div>
    </header>

    <main>
        <?php
        // Nếu URL chưa có tham số 'page' → tự động chuyển sang ?page=login
        if (!isset($_GET['page'])) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?page=login");
            exit();
        }

        // Gán giá trị mặc định an toàn cho biến
        $url = $_GET['url'] ?? '';
        $page = $_GET['page'] ?? 'login';
        ?>

        <div class="form-card">
            <div class="top-side">
                <img src="../../assets/imgs/icon1.png" alt="icon">

                <?php if ($page === "login"): ?>
                    <span class="greeting" id="hi">Hi, my friend!</span>
                <?php else: ?>
                    <span class="greeting" id="welcome">Welcome</span>
                <?php endif; ?>
            </div>

            <div class="bottom-side" id="form-container">
                <?php
                if ($page === "login") {
                    include './login.php';
                } elseif ($page === "register") {
                    include './register.php';
                }
                ?>
            </div>  
        </div>
    </main>
    <script src="../../assets/js/form.js" defer></script>
   
</body>
</html>

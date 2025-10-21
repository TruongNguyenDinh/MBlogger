<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="../../assets/css/header.css">
<div class="container-header">
    <div class="logo-header">
        MBlogger
    </div>
    <div class="search-header">
        <input type="text" name="search-header" placeholder="Search: ID,name repo, topic">
        <div class="header-result">
            <?php include('../components/show-searching.php')?>
        </div>
    </div>
    <div class="menu-header">
        <div class="home-menu active"><a href="../home/home.php">Home</a></div>
        <div class="news-menu"><a href="../news/news.php">News</a></div>
        <div class="profile-menu"><a href="../profile/profile.php">Profile</a></div>
        <div class="repo-menu"><a href="../repo/repo.php">Repo</a></div>
        <div class="setting-menu"><a href="../setting/setting.php">Setting</a></div>
        <?php if (isset($_SESSION['user'])): ?>
            <div class="so-menu" id="so-menu"><a href="../../api/sign_out.php">Sign out</a></div>
        <?php else :?>
            <div class="so-menu" id="so-menu"><a href="../../views/form/form.php">Sign in</a></div>
        <?php endif; ?>
        
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    const currentPage = path.split("/").pop(); // lấy tên file, vd: 'home.php'

    // Xóa tất cả active cũ
    document.querySelectorAll(".menu-header > div").forEach(div => {
        div.classList.remove("active");
    });

    // Tìm thẻ a có href chứa trang hiện tại
    const activeLink = document.querySelector(`.menu-header a[href*="${currentPage}"]`);
    if (activeLink) {
        activeLink.parentElement.classList.add("active");
    }
});
</script>
<script src="../../assets/js/header.js"></script>

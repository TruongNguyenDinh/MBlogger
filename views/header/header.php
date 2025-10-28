<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    include('../../controls/profilecontroller.php');
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/header.css">
<div class="container-header">
    <div class="logo-header">
        MBlogger
    </div>
    <div class="search-header">
        <input type="text" name="search-header" placeholder="Search: ID,name repo, topic">
        <div class="header-result">
        </div>
    </div>
    <div class="menu-header">
        <!-- Home -->
        <div class="menu-header_elem">
            <a href="../home/home.php">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
        </div>
        <!-- News -->
        <div class="menu-header_elem">
            <a href="../news/news.php">
                <i class="fa-solid fa-newspaper"></i>
                <span>News</span>
            </a>
        </div>
        <!-- Profile -->
        <div class="menu-header_elem">
            <a href="../profile/profile.php">
                <i class="fa-solid fa-address-card"></i>
                <span>Profile</span>
            </a>
        </div>
        <!-- Repo -->
        <div class="menu-header_elem">
            <a href="../repo/repo.php">
                <i class="fa-solid fa-shop"></i>
                <span>Repo</span>
            </a>
        </div>
        <!-- Setting -->
        <div class="menu-header_elem">
            <a href="../setting/setting.php">
                <i class="fa-solid fa-wrench"></i>
                <span>Setting</span>
            </a>
        </div>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="user_menu">
                <div class="header_user_avt" id="header_user_avt">
                    <img src="<?= $_SESSION['user']['url_avt']; ?>" alt="User's avatar">
                </div>
                <div class="so-menu" id="so-menu">
                    <a href="../../api/sign_out.php">Sign out</a>
                </div>
            </div>         
        <?php else :?>
            <div class="menu-header_elem">
                <a href="../../views/form/form.php">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Sign in</span>
                </a>
            </div>  
        <?php endif; ?>
        
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Lấy tên file hiện tại (bỏ query string nếu có)
  const currentPage = window.location.pathname.split("/").pop().split("?")[0];

  // Xóa hết class active cũ
  document.querySelectorAll(".menu-header_elem").forEach(elem => {
    elem.classList.remove("active");
  });

  // Tìm link có href trùng với trang hiện tại
  const activeLink = document.querySelector(`.menu-header_elem a[href*="${currentPage}"]`);
  if (activeLink) {
    activeLink.closest(".menu-header_elem").classList.add("active");
  }
});

document.getElementById('header_user_avt').addEventListener('click', function() {
  const menu = document.getElementById('so-menu');
  menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
});

// Ẩn menu khi click ra ngoài
document.addEventListener('click', function(e) {
  const avatar = document.getElementById('header_user_avt');
  const menu = document.getElementById('so-menu');
  if (!avatar.contains(e.target) && !menu.contains(e.target)) {
    menu.style.display = 'none';
  }
});
</script>
<script src="../../assets/js/header.js"></script>

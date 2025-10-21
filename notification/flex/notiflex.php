<link rel="stylesheet" href="../../assets/css/notification.css">
<?php if (!empty($showLoginPopup) && $showLoginPopup): ?>
<div class="nf-overlay" id="loginPopup">
    <div class="nf-container">
        <div class="nf-top-side">
            <div class="nf-top-side_title">MBlogger</div>
            <div class="nf-top-side_intro">This action requires you to log in.</div>
        </div>
        <div class="nf-below-side">
            <div class="nf-login"><a href="/mblogger/views/form/form.php">Login</a></div>
            <div class="nf-cancel" id="loginCancel">Cancel</div>
        </div>
        <div class="nf-footer">
            <a href="/mblogger/views/form/register.php">I haven't got an account</a>
        </div>
    </div>
</div>
<?php endif; ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const loginCancel = document.getElementById("loginCancel");
    const loginPopup = document.getElementById("loginPopup");

    if (loginCancel && loginPopup) {
        loginCancel.addEventListener("click", () => {
        loginPopup.style.display = "none"; // ẩn popup

        // Nếu có lịch sử trang trước, quay lại
        if (document.referrer && document.referrer !== window.location.href) {
            window.location.href = document.referrer;
        } else {
            // Nếu không có lịch sử, điều hướng về Home
            window.location.href = "/mblogger/views/home/home.php";
        }
        });
    }
    });
</script>

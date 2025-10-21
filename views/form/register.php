<div class="general-form">
    <form id="register-form" action="../../controls/registercontroller.php" method="post">
        <div class="title">
            <span id="title-login">User Registration</span>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="username" placeholder="User name">
        </div>

        <div class="input-group">
            <i class="fa-solid fa-key"></i>
            <input type="password" name="password" placeholder="Password">
        </div>

        <div class="input-group">
            <i class="fa-solid fa-key"></i>
            <input type="password" name="password_confirm" placeholder="Password again">
        </div>

        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" placeholder="Email">
        </div>

        <div id="action-section">
            <a id="back-btn">Back</a>
            <button type="submit" id="join-btn">Join us</button>
        </div>
    </form>
</div>

<!-- Toast container -->
<div id="toast-container"></div>

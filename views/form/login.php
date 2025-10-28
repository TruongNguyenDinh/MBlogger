<div class="general-form">
    <form id="loginForm" action="../../controls/logincontroller.php" method="post">
        <div class="title">
            <span id="title-login">User Login</span>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="username" placeholder="User name" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-key"></i>
            <input type="password" name="pass" placeholder="Password" required>
        </div>

        <div id="remember-section">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>
        </div>

        <div id="action-section" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="#" id="toggle-register">I haven't got an account</a>
            <button type="submit">Let's go!</button>
        </div>
    </form>
</div>

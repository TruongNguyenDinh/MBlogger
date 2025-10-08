<div class="general-form">
    <form action="../../controls/logincontroller.php" method="post">
        <div class="title">
            <span id='title-login'>user login</span>
        </div>
        <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="username" placeholder="User name">
        </div>

        <div class="input-group">
            <i class="fa-solid fa-key"></i>
            <input type="password" name="pass" placeholder="Password">
        </div>

        <div id="remember-section">
            <input type="radio" name="remember" id="remember">
            <label for="remember">remember me</label>
        </div>
        <div id ="action-section" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="#" id ="toggle-register">I haven't got an account</a>
            <button type="submit">let's go!</button>
        </div>
    </form>
</div>

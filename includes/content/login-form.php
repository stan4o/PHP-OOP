<div id="login-form">
    <form action="login.php" method="post">
        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" autocomplete="off">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="off">
        </div>

        <div class="field">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
        <span><input type="submit" value="Log in"> or <a href="register.php">Register</a></span>
    </form>
</div>
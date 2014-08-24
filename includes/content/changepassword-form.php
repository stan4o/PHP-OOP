<form action="" method="post">
    <div class="field">
        <label for="password_current">Current password</label>
        <input type="password" id="password_current" name="password_current">
    </div>

    <div class="field">
        <label for="password_new">New password</label>
        <input type="password" id="password_new" name="password_new">
    </div>

    <div class="field">
        <label for="password_new_again">New password again</label>
        <input type="password" id="password_new_again" name="password_new_again">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <span><input type="submit" value="Change"> or <a href="index.php">Go Back</a></span>
</form>
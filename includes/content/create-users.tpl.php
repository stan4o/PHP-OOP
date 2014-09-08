<form action="create.php?action=users" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo escape(Input::get('username'));?>">
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" id="password" name="password">
    </div>

    <div class="field">
        <label for="password_again">Repeat the password</label>
        <input type="password" id="password_again" name="password_again">
    </div>

    <div class="field">
        <label for="name">Enter a name</label>
        <input type="text" id="name" name="name" value="<?php echo escape(Input::get('name'));?>">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>
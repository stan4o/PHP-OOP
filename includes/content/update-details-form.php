<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo escape($user->data()->name); ?>">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <span><input type="submit" value="Update"> or <a href="index.php">Back</a></span>
</form>
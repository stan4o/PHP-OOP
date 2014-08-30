<form action="" method="post">
    <div class="field">
        <label for="title">Title</label>
        <input type="text" id="title" name="title">
    </div>

    <div class="field">
        <label for="body">Body</label>
        <textarea id="body" name="body" rows="5" cols="30"></textarea>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <span><input type="submit" value="Create"> or <a href="index.php">Back</a></span>
</form>
<h3>Update Posts Form</h3>

<form action="" method="post">
    <div class="field">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo escape($this->data->title); ?>">
    </div>

    <div class="field">
        <label for="body">Body</label>
        <textarea id="body" name="body" rows="5" cols="30"><?php echo escape($this->data->body); ?></textarea>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <span><input type="submit" value="Update"> or <a href="index.php">Cancel</a></span>
</form>


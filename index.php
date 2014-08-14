<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();
$post = new Post();

if ($post->find()) {
    $data = $post->data();
    echo $post->count();

    if ($post->count() > 1) {
        foreach ($data as $post) {
            ?>

            <h3><?php echo $post->title; ?></h3>
            <p>Date created: <em><time  datetime="<?php echo $post->created; ?>"><?php echo $post->created; ?></time></em></p>
            <p><?php echo $post->body; ?></p>

            <?php
        }
    } else {
        $post = $post->data();
        ?>

        <h3><?php echo $post->title; ?></h3>
        <p>Date created: <em><time  datetime="<?php echo $post->created; ?>"><?php echo $post->created; ?></time></em></p>
        <p><?php echo $post->body; ?></p>

        <?php
    }
} else {
    echo "There are no posts";
}
?>


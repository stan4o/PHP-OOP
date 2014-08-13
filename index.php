<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();
$post = new Post();
$data = $post->data();

foreach ($data as $post) {
?>

<h3><?php echo $post->title; ?></h3>
<p>Date created: <em><time  datetime="<?php echo $post->created; ?>"><?php echo $post->created; ?></time></em></p>
<p><?php echo $post->body; ?></p>

<?php
}
<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();

if ($user->isLoggedIn()) {

?>

<p>Hello <a href="profile.php?user=<?php echo $user->data()->username; ?>"><?php echo $user->data()->username; ?></a>!</p>
<?php if ($user->hasPermission('admin')) echo "<p>Your are an administrator</p>"; ?>
<hr>
<ul>
    <li><a href="update.php">Update details</a></li>
    <li><a href="changepassword.php">Change password</a></li>
    <li><a href="profile.php">Profile</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php

} else {

echo '<p>You can <a href="login.php">log in</a> or <a href="register.php">register</a>.</p>';

}
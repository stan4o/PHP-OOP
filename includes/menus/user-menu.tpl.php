<div id="user-menu">
    <ul>
        <li><a href="profile.php?user=<?php echo escape($this->user->data()->username); ?>">Profile</a></li>
        <li><a href="update.php?action=details">Update Details</a></li>
        <li><a href="changepassword.php">Change Your Password</a></li>
        <?php if ($this->user->hasPermission('admin')) include 'includes/menus/admin-menu.tpl.php'; ?>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<table border="1" cellpadding="5">
    <thead>
        <th>Name</th>
        <th>Username</th>
        <th>Joined</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php if (is_array($this->data)) {
            foreach ($this->data as $user) : ?>
                <tr>
                    <td>
                        <a href="update.php?action=details&amp;id=<?php echo escape(intval($user->id)); ?>"><?php echo escape($user->name); ?></a>
                    </td>
                    <td>
                        <a href="update.php?action=details&amp;id=<?php echo escape(intval($user->id)); ?>"><?php echo escape($user->username); ?></a>
                    </td>
                    <td>
                        <em><time  datetime="<?php echo escape($user->created); ?>"><?php echo escape($user->joined); ?></time></em>
                    </td>
                    <td>
                        <a href="update.php?action=details&amp;id=<?php echo escape(intval($user->id)); ?>">Update</a>
                        <a href="delete.php?action=users&amp;id=<?php echo escape(intval($user->id)); ?>">Delete</a>
                    </td>
                </tr>
        <?php endforeach; } else { ?>
                <tr>
                    <td>
                        <a href="update.php?action=details&amp;id=<?php echo escape(intval($this->data->id)); ?>"><?php echo escape($this->data->name); ?></a>
                    </td>
                    <td>
                        <a href="update.php?action=details&amp;id=<?php echo escape(intval($this->data->id)); ?>"><?php echo escape($this->data->username); ?></a>
                    </td>
                    <td>
                        <em><time  datetime="<?php echo escape($this->data->created); ?>"><?php echo escape($this->data->joined); ?></time></em>
                    </td>
                    <td>
                        <a href="update.php?action=details&amp;id=<?php echo escape(intval($this->data->id)); ?>">Update</a>
                        <a href="delete.php?action=users&amp;id=<?php echo escape(intval($this->data->id)); ?>">Delete</a>
                    </td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<div class="links">
    <a href="create.php?action=users">Create new user</a> or go
    <a href="index.php">Back</a>
</div>
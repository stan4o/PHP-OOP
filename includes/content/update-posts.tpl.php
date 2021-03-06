<table border="1" cellpadding="5">
    <thead>
        <th>Title</th>
        <th>Date Created</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php if (is_array($this->data)) {
            foreach ($this->data as $post) : ?>
                <tr>
                    <td>
                        <a href="update.php?action=posts&amp;id=<?php echo escape(intval($post->id)); ?>"><?php echo escape($post->title); ?></a>
                    </td>
                    <td>
                        <em><time  datetime="<?php echo escape($post->created); ?>"><?php echo escape($post->created); ?></time></em>
                    </td>
                    <td>
                        <a href="update.php?action=posts&amp;id=<?php echo escape(intval($post->id)); ?>">Update</a>
                        <a href="delete.php?action=posts&amp;id=<?php echo escape(intval($post->id)); ?>">Delete</a>
                    </td>
                </tr>
        <?php endforeach; } else { ?>
                <tr>
                    <td>
                        <a href="update.php?action=posts&amp;id=<?php echo escape(intval($this->data->id)); ?>"><?php echo escape($this->data->title); ?></a>
                    </td>
                    <td>
                        <em><time  datetime="<?php echo escape($this->data->created); ?>"><?php echo escape($this->data->created); ?></time></em>
                    </td>
                    <td>
                        <a href="update.php?action=posts&amp;id=<?php echo escape(intval($this->data->id)); ?>">Update</a>
                        <a href="delete.php?action=posts&amp;id=<?php echo escape(intval($this->data->id)); ?>">Delete</a>
                    </td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<div class="links">
    <a href="create.php?action=posts">Create new post</a> or go
    <a href="index.php">Back</a>
</div>
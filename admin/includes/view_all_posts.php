<?php

$filter = '';

if (isset($_POST['filter_posts'])) {
    $filter  = $_POST['filter'];
}

if (isset($_POST['bulk_action'])) {
    $post_ids = $_POST['bulk_action'];
    $action = $_POST['action'];

    foreach ($post_ids as $post_id) {
        switch ($action) {
            case 'delete':
                $delete_query = 'DELETE FROM posts WHERE id  = ?';
                $result = mysqli_execute_query($conn, $delete_query, ["$post_id"]);
                confirm($result);
                break;
            case 'clone':
                $clone_query = 'INSERT INTO posts (post_category_id, post_title, post_author, post_image, post_content, post_status) SELECT post_category_id, post_title, post_author, post_image, post_content, post_status FROM posts WHERE id  = ?';
                $result = mysqli_execute_query($conn, $clone_query, ["$post_id"]);
                confirm($result);
                break;
            case 'draft':
            case 'published':
                $update_query = 'UPDATE posts SET post_status = ? WHERE id  = ?';
                $result = mysqli_execute_query($conn, $update_query, ["$action", "$post_id"]);
                confirm($result);
                break;
        }
    }
    header('Location: posts.php');
}

?>

<table class="table table-bordered table-hover">
    <form class="form" action="" method="POST">
        <div class="form-group">
            <div class="col-xs-4 remove_space_left">
                <select name="filter" class="form-control">
                    <?php
                    ?>
                    <option <?php echo $filter === '' ? 'selected' : '' ?> value="">All posts</option>
                    <option <?php echo $filter === 'draft' ? 'selected' : '' ?> value="draft">Draft</option>
                    <option <?php echo $filter === 'published' ? 'selected' : '' ?> value="published">Published</option>
                </select>
            </div>
            <button class="btn btn-secondary" type="submit" name="filter_posts">Filter posts</button>
            <a href="posts.php?source=add_post" class="btn btn-secondary">Add New Post</a>
    </form>
    </div>
    <thead>
        <tr>
            <th><input id='header_checkbox' type="checkbox"></th>
            <th>Post id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Tags</th>
            <th>Views</th>
            <th>Comments</th>
            <th>Date </th>
        </tr>
    </thead>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <tbody>
            <?php
            $query = 'SELECT * FROM POSTS WHERE post_status LIKE ? ';
            $result = mysqli_execute_query($conn, $query, ["%$filter%"]);
            while ($row = mysqli_fetch_assoc($result)) {

                $post_category =  get_category_by_id($row['post_category_id']);

                $post_id = $row['id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_status = $row['post_status'];
                $post_tags = $row['post_tags'];
                $post_views = $row['post_views'];
                $post_comments = $row['post_comment_count'];
                $post_date = $row['post_date'];

                echo "<tr>";
                echo "<td><input id='post_checkbox' name='bulk_action[]' value='$post_id' type='checkbox'></td>";
                echo "<td>$post_id</td>";
                echo "<td>$post_author</td>";
                echo "<td><a href='../post.php?id=$post_id'>$post_title</a></td>";
                echo "<td>$post_category</td>";
                echo "<td>$post_status</td>";
                echo "<td>$post_tags</td>";
                echo "<td>$post_views</td>";
                echo "<td><a href='post_comments.php?post_id=$post_id '>$post_comments</a></td>";
                echo "<td>$post_date</td>";
                echo "<td> <a href='posts.php?source=edit_post&post_id=$post_id'>edit</a></td>";
                echo "<td> <a href='posts.php?delete=$post_id'>delete</a></td>";
                echo "<tr>";
            }
            ?>

            <tr>
                <td colspan="11">
                    <div class="col-xs-4 remove_space_left">
                        <select name="action" class="form-control">
                            <?php
                            ?>
                            <option value="draft">Draft</option>
                            <option value="published">Publish</option>
                            <option value="delete">Delete</option>
                            <option value="clone">Clone</option>
                        </select>
                    </div>
                    <button type="submit" name="bulk_actions_submit" class="btn btn-primary">Apply to selected posts</button>
                </td>
            </tr>
        </tbody>
    </form>
</table>

<?php
if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $query = 'DELETE FROM posts WHERE id = ?';
    $result = mysqli_execute_query($conn, $query, ["$post_id"]);

    confirm($result);

    if ($result) {
        header('Location: posts.php');
    }
}
?>
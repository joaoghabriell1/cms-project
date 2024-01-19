<?php
$post_id = null;
$current_url = strtok($_SERVER['REQUEST_URI'], '?');

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $current_url .= "?post_id=$post_id";
}

?>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>In Response to</th>
            <th>Status</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php

        if (isset($post_id)) {
            $query = 'SELECT * FROM comments WHERE comment_post_id = ?';
            $result = mysqli_execute_query($conn, $query, ["$post_id"]);
        } else {
            $query = 'SELECT * FROM comments';
            $result = mysqli_execute_query($conn, $query);
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            $comment_post_title = get_post_title_by_id($comment_post_id);

            $link_sufix = isset($post_id) ? '&' : '?';

            echo "<tr>";
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_content</td>";
            echo "<td><a href='/cms-project/post.php?id=$comment_post_id'>$comment_post_title</a></td>";
            echo "<td>$comment_status</td>";
            echo "<td>$comment_date</td>";
            echo "<td><a href='$current_url" . $link_sufix . "approve=$comment_id'>Approve</a></td>";
            echo "<td><a href='$current_url" . $link_sufix . "unapprove=$comment_id'>Unapprove</a></td>";
            echo "<td><a href='$current_url" . $link_sufix . "?delete=$comment_id'>Delete</a></td>";
            echo "<tr>";
        }
        ?>
        <?php echo $current_url ?>;
    </tbody>

</table>

<?php
if (isset($_GET['delete'])) {
    $comment_id = $_GET['delete'];
    $query = 'DELETE FROM comments WHERE comment_id = ?';
    $result = mysqli_execute_query($conn, $query, ["$comment_id"]);

    confirm($result);

    if ($result) {
        header("Location: $current_url");
    }
}

if (isset($_GET['approve'])) {
    $comment_id = $_GET['approve'];
    $query = 'UPDATE comments SET comment_status = "approved" WHERE comment_id = ?';

    $result = mysqli_execute_query($conn, $query, ["$comment_id"]);

    confirm($result);

    if ($result) {
        header("Location: $current_url");
    }
}

if (isset($_GET['unapprove'])) {
    $comment_id = $_GET['unapprove'];
    $query = 'UPDATE comments SET comment_status = "unapprove" WHERE comment_id = ?';

    $result = mysqli_execute_query($conn, $query, ["$comment_id"]);

    confirm($result);

    if ($result) {
        header("Location: $current_url");
    }
}


?>
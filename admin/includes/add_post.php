<?php

if (isset($_POST['create_post'])) {
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['post_author'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_status = $_POST['post_status'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_image, post_content, post_tags, post_comment_count, post_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $result = mysqli_execute_query($conn, $query, ["$post_category_id", "$post_title", "$post_author", "$post_image", "$post_content", "$post_tags", "$post_comment_count", "$post_status"]);

    confirm($result);

    if ($result) {
        header('Location: posts.php');
    }
}

?>


<form action="#" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input class="form-control" name="post_title" type="text">
    </div>
    <div class="form-group">
        <h5>Category</h5>
        <select name="post_category_id" id="post_category">
            <?php
            $query = "SELECT * FROM categories";
            $result = mysqli_execute_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['id'];
                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_title">Post Author</label>
        <input class="form-control" name="post_author" type="text">
    </div>
    <div class="form-group">
        <label for="post_title">Post Status</label>
        <select name="post_status" id="post_status">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_title">Post Image</label>
        <input class="form-control" name="image" type="file">
    </div>
    <div class="form-group">
        <label for="post_title">Post Tags</label>
        <input class="form-control" name="post_tags" type="text">
    </div>
    <div class="form-group">
        <label for="post_title">Post Content</label>
        <textarea class="form-control" id="summernote" name="post_content" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Publish" name="create_post" class="btn btn-primary">
    </div>
</form>
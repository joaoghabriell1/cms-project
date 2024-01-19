<?php

if (isset($_POST['update_post'])) {;
    $post_id = $_GET['post_id'];

    $post_author = $_POST['post_author'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date("Y-m-d H:i:s");

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE id = $post_id";

        $select_image = mysqli_execute_query($conn, $query);

        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET post_title = ?, post_category_id = ?, post_date = ?, post_author = ?, post_status = ?, post_tags = ?, post_content = ?, post_image = ? WHERE id = ?";

    $result = mysqli_execute_query($conn, $query, ["$post_title", "$post_category_id", "$post_date", "$post_author", "$post_status", "$post_tags", "$post_content", "$post_image", "$post_id"]);

    confirm($result);

    if ($result) {
        header('Location: posts.php?source=view_all_posts');
    }
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $query = 'SELECT * FROM POSTS WHERE id = ?';
    $result = mysqli_execute_query($conn, $query, ["$post_id"]);

    while ($row = mysqli_fetch_assoc($result)) {
        $post_id = $row['id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
        $post_image = $row['post_image'];
    }
}

?>

<form action="#" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?php echo isset($post_title) ?  $post_title : "" ?>" class="form-control" name="post_title" type="text">
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
        <label for="post_author">Post Author</label>
        <input value="<?php echo isset($post_author) ?  $post_author : "" ?>" class="form-control" name="post_author" type="text">
    </div>
    <div class="form-group">
        <label for="post_title">Post Status</label>
        <select name="post_status" id="post_status">
            <option value="published">Published</option>
            <option <?php echo $post_status === 'draft' ? 'selected' : null ?> value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input class="form-control" name="image" type="file">
        <h5>Current image</h5>
        <img width="400px" src="../images/<?php echo $post_image ?>" alt="">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo isset($post_tags) ?  $post_tags : "" ?>" class="form-control" name="post_tags" type="text">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" cols="30" rows="10"><?php echo isset($post_content) ?  $post_content : null ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Publish" name="update_post" class="btn btn-primary">
    </div>
</form>
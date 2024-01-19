<?php include 'includes/db.php' ?>
<?php include '../cms-project/admin/functions.php' ?>

<?php

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    update_post_views($post_id);
}

if (isset($_POST['create_comment'])) {
    $comment_author = $_POST['comment_author'];
    $author_email = $_POST['author_email'];
    $comment_content = $_POST['comment'];
    $comment_status = 'unapproved';

    $query = "INSERT INTO comments (comment_post_id, comment_author, author_email, comment_content, comment_status) VALUES (?, ?, ?, ?, ?)";
    $result = mysqli_execute_query($conn, $query, ["$post_id", "$comment_author", "$author_email", "$comment_content", "$comment_status"]);

    confirm($result);

    if ($result) {
        header("Location: post.php?id=$post_id");
    }
}

?>

<?php include 'includes/header.php' ?>

<?php include 'includes/navigation.php' ?>

<div class="container">

    <div class="row">

        <div class="col-md-8">
            <?php
            if (isset($_GET['id'])) {
                $post_id = $_GET['id'];
                $query = "SELECT * FROM posts WHERE id = ?";
                $result = mysqli_execute_query($conn, $query, ["$post_id"]);

                while ($row = mysqli_fetch_assoc($result)) {
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
                    $post_views = $row['post_views'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
            ?>
                    <h2>
                        <a href="#"> <?php echo $post_title ?> </a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                    <p>Views: <?php echo $post_views ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $row['post_image'] ?>" alt="">
                    <hr>
                    <p> <?php echo $post_content ?> </p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
            <?php
                }
            }
            ?>
        </div>

        <?php include 'includes/sidebar.php' ?>

    </div>
    <div class="well">
        <h4>
            Leave a comment:
        </h4>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="comment_author">Name</label>
                <input class="form-control" id="comment_author" type="text" name="comment_author">
            </div>
            <div class="form-group">
                <label for="author_email">Email</label>
                <input class="form-control" id="author_email" type="email" name="author_email">
            </div>
            <div class="form-group">
                <label for="comment">Your Comment</label>
                <textarea class="form-control" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </hr>
    <?php
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM comments WHERE comment_post_id = ? AND comment_status = 'approved' ORDER BY comment_date DESC";
        $result = mysqli_execute_query($conn, $query, ["$post_id"]);

        confirm($result);

        while ($row = mysqli_fetch_assoc($result)) {
            $comment_author = $row['comment_author'];
            $author_email = $row['author_email'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
    ?>
            <div class="media">
                <a href="" class="pull-left">
                    <img src="" alt="" class="media-object">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <?php echo $comment_author ?>
                        <small><?php echo $author_email ?></small>
                        <small><?php echo $comment_date ?></small>
                    </h4>
                    <?php echo $comment_content ?>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <hr>
    <?php include 'includes/footer.php' ?>
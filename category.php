<?php include 'includes/db.php' ?>


<?php

$search_query = '';

if (isset($_POST['submit'])) {
    $search_query = $_POST['query'];
}

?>

<?php include 'includes/header.php' ?>

<!-- Navigation -->

<?php include 'includes/navigation.php' ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php

            if (isset($_GET['category'])) {
                $category_id = $_GET['category'];
                $query = "SELECT * FROM posts WHERE post_category_id = ?";

                $result = mysqli_execute_query($conn, $query, ["$category_id"]);

                while ($row = mysqli_fetch_assoc($result)) {
                    $post_id = $row['id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
            ?>
                    <h2>
                        <a href="post.php?id=<?php echo $post_id ?>"> <?php echo $post_title ?> </a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on<?php echo $post_date ?></p>
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
    <!-- /.row -->

    <hr>
    <?php include 'includes/footer.php' ?>
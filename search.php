<?php include 'includes/db.php' ?>



<?php include 'includes/header.php' ?>

<!-- Navigation -->

<?php include 'includes/navigation.php' ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            if (isset($_POST['submit'])) {
                $search = $_POST['search'];
                $query = "SELECT * FROM posts WHERE post_tags LIKE ?";

                $result = mysqli_execute_query($conn, $query, ["%$search%"]);

                if (!$result) {
                    die('Query failed' . mysqli_error($conn));
                }

                $count = mysqli_num_rows($result);

                if ($count == 0) {
                    echo "<h1> NO RESULTS </h1>";
                } else {
                    $query = 'SELECT * FROM posts';
                    $select_all_posts_query = mysqli_execute_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_content = $row['post_content'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
            ?>
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>
                        <h2>
                            <a href="#"> <?php echo $post_title ?> </a>
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
            }

            ?>
        </div>

        <?php include 'includes/sidebar.php' ?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include 'includes/footer.php' ?>
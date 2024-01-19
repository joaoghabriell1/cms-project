<?php include 'includes/db.php' ?>
<?php include '../cms-project/admin/functions.php' ?>

<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php

            if (isset($_GET['author'])) {

                $author = $_GET['author'];

                $query = "SELECT * FROM posts WHERE post_author = ?";

                $result = mysqli_execute_query($conn, $query, ["$author"]);


                while ($row = mysqli_fetch_assoc($result)) {
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
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
    <?php include 'includes/footer.php' ?>
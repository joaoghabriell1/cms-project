<?php include 'admin/functions.php' ?>
<?php include 'includes/db.php' ?>

<?php include 'includes/header.php' ?>

<?php include 'includes/navigation.php' ?>

<?php
$limit = 3;
$curr_page = 1;
$total_posts = get_total_posts_published();
$total_pages = ceil($total_posts / $limit);

if (isset($_GET['page'])) {
    $curr_page = $_GET['page'];
}
?>

<div class="container">

    <div class="row">
        <div class="col-md-8">
            <?php
            $start_from_post = ($curr_page  - 1) * $limit;

            $query  = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $limit OFFSET $start_from_post";
            $result = mysqli_execute_query($conn, $query);

            if (mysqli_num_rows($result) === 0) {
                echo 'No posts were created yet.';
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $post_id = $row['id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_content = substr($row['post_content'], 0, 50);
                    $post_status = $row['post_status'];

                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];

                    if ($post_status === 'published') {
            ?>
                        <h2>
                            <a href="post.php?id=<?php echo $post_id ?>"> <?php echo $post_title ?> </a>
                        </h2>
                        <p class="lead">
                            by <a href="author_posts.php?author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <a href="post.php?id=<?php echo $post_id ?>">
                            <img class="img-responsive" src="images/<?php echo $row['post_image'] ?>" alt="">
                        </a>
                        <hr>
                        <p> <?php echo $post_content ?> </p>
                        <a class="btn btn-primary" href="post.php?id=<?php echo $post_id ?> ">Read More <span class=" glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
            <?php
                    }
                }
            }
            ?>
        </div>
        <?php include 'includes/sidebar.php' ?>
    </div>
    <hr>
    <ul class="pagination">
        <?php

        for ($i = 1; $i <= $total_pages; $i++) {
            $link_is_active = $curr_page == $i;
            $class = $link_is_active ? 'active' : '';
            echo "<li class='page-item $class' ><a class='page-link' href='index.php?page=$i'>$i</a></li>";
        }
        ?>
    </ul>
    <?php include 'includes/footer.php' ?>
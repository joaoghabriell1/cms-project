<?php include 'includes/admin_header.php' ?>
<?php

$total_posts_count = get_posts_total_count();
$total_categories_count = get_categories_total_count();
$total_users_count = get_users_total_count();
$total_comments_count = get_comments_total_count();

?>

<div id="wrapper">
    <?php include 'includes/admin_navigation.php' ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <small>
                            <?php echo $_SESSION['username'] ?>
                            <?php echo $_SESSION['role'] ?>
                        </small>
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'> <?php echo $total_posts_count ?>
                                    </div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'> <?php echo $total_comments_count ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'> <?php echo $total_users_count ?></div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'> <?php echo $total_categories_count ?> </div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <?php

            $query = "SELECT * FROM posts WHERE post_status = 'published'";
            $select_all_published_posts = mysqli_execute_query($conn, $query);
            $total_published_posts_count = mysqli_num_rows($select_all_published_posts);

            $query = "SELECT * FROM posts WHERE post_status = 'draft'";
            $select_all_draft_posts = mysqli_execute_query($conn, $query);
            $total_draft_posts_count = mysqli_num_rows($select_all_draft_posts);

            $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
            $select_unapproved_comments = mysqli_execute_query($conn, $query);
            $total_unapproved_comments_count = mysqli_num_rows($select_unapproved_comments);

            $query = "SELECT * FROM users WHERE role = 'subscriber'";
            $select_subscribers = mysqli_execute_query($conn, $query);
            $total_subscribers_count = mysqli_num_rows($select_subscribers);
            ?>

            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Date', 'Count'],
                            <?php
                            $element_text = ['Categories', 'All Posts', 'Published Posts', 'Draft posts',  'Users', 'Subscribers', 'Comments', 'Unapproved comments'];
                            $element_count = [$total_categories_count, $total_posts_count, $total_published_posts_count, $total_draft_posts_count,  $total_users_count, $total_subscribers_count, $total_comments_count, $total_unapproved_comments_count];
                            for ($i = 0; $i < count($element_text); $i++) {
                                $bar_2 = "['$element_text[$i]', $element_count[$i]] ,";

                                echo $bar_2;
                            }
                            ?>
                        ]);

                        var options = {
                            chart: {}
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>
                <div id="columnchart_material" style="width: auto; height: 500px;"></div>
            </div>
        </div>

    </div>

    <?php include 'includes/admin_footer.php' ?>
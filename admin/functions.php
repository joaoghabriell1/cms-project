<?php

function confirm($result)
{
    global $conn;

    if (!$result) {
        die("QUERY FAILED" . mysqli_error($conn));
    }
}

function get_posts_total_count()
{
    global $conn;
    $query = 'SELECT * FROM posts';
    $result = mysqli_execute_query($conn, $query,);
    confirm($result);

    $total_posts_count = $result->num_rows;

    return $total_posts_count;
}
function get_users_total_count()
{
    global $conn;
    $query = 'SELECT * FROM users';
    $result = mysqli_execute_query($conn, $query,);
    confirm($result);

    $total_users_count = $result->num_rows;

    return $total_users_count;
}
function get_categories_total_count()
{
    global $conn;
    $query = 'SELECT * FROM categories';
    $result = mysqli_execute_query($conn, $query,);
    confirm($result);

    $total_categories_count = $result->num_rows;

    return $total_categories_count;
}
function get_comments_total_count()
{
    global $conn;
    $query = 'SELECT * FROM comments';
    $result = mysqli_execute_query($conn, $query,);
    confirm($result);

    $total_comments_count = $result->num_rows;

    return $total_comments_count;
}



function get_post_title_by_id($post_id)
{
    global $conn;

    $query = "SELECT * from posts WHERE id = ?";

    $result = mysqli_execute_query($conn, $query, ["$post_id"]);

    confirm($result);

    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) === 0) {
        $post_title = 'The post was deleted';
    } else {

        $post_title = $row['post_title'];
    }

    return $post_title;
}

function get_category_by_id($category_id)
{
    global $conn;

    $query = "SELECT * from categories WHERE id = ?";

    $result = mysqli_execute_query($conn, $query, ["$category_id"]);

    confirm($result);

    $row = mysqli_fetch_assoc($result);

    $post_category = $row['cat_title'];

    return $post_category;
}

function get_total_users_online()
{
    global $conn;

    $session = session_id();
    $time = time();
    $time_out_in_seconds = 60;
    $time_out = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_execute_query($conn, $query);
    $count = mysqli_num_rows($send_query);

    if ($count == 0) {
        mysqli_execute_query($conn, "INSERT INTO users_online (session, time) VALUES ('$session','$time')");
    } else {
        mysqli_execute_query($conn, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $users_online_query = "SELECT * FROM users_online WHERE time > '$time_out'";
    $users_query_result = mysqli_execute_query($conn, $users_online_query);

    $users_count = mysqli_num_rows($users_query_result);

    return $users_count;
}


function get_total_posts_published()
{
    global $conn;

    $query = "SELECT * FROM posts WHERE post_status = 'published'";
    $result = mysqli_execute_query($conn, $query);

    $total_posts = mysqli_num_rows($result);

    return $total_posts;
}


function update_post_views($post_id)
{

    global $conn;

    $current_views_count = null;

    $get_current_views_count_query = 'SELECT post_views FROM posts WHERE id = ?';

    $result = mysqli_execute_query($conn, $get_current_views_count_query, ["$post_id"]);

    confirm($result);

    while ($row = mysqli_fetch_assoc($result)) {
        $current_views_count =  $row['post_views'] + 1;
    }

    $upgrade_views_count_query = 'UPDATE posts SET post_views = ? WHERE id = ?';

    $result_2 = mysqli_execute_query($conn, $upgrade_views_count_query, ["$current_views_count", "$post_id"]);

    confirm($result_2);
}

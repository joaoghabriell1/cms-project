<?php include 'includes/admin_header.php' ?>

<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];


    $query = 'SELECT * FROM users WHERE user_id = ?';
    $result = mysqli_execute_query($conn, $query, ["$user_id"]);

    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_image = $row['user_image'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
        $user_role = $row['role'];
    }
}

?>


<div id="wrapper">
    <?php include 'includes/admin_navigation.php' ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $user_id ?>
                        Posts
                    </h1>
                    <?php include 'functions.php' ?>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input value="<?php echo isset($username) ?  $username : "" ?>" class="form-control" id="username" name="username" type="text">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input value="<?php echo isset($user_email) ?  $user_email : "" ?>" class="form-control" id="user_email" name="user_email" type="email">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input value="<?php echo isset($user_password) ?  $user_password : "" ?>" class="form-control" id="user_password" name="user_password" type="password">
                        </div>
                        <div class="form-group">
                            <label for="user_firstname">Firstname</label>
                            <input value="<?php echo isset($user_firstname) ?  $user_firstname : "" ?>" class="form-control" id="user_firstname" name="user_firstname" type="text">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Lastname</label>
                            <input value="<?php echo isset($user_lastname) ?  $user_lastname : "" ?>" class="form-control" id="user_lastname" name="user_lastname" type="text">
                        </div>
                        <div class="form-group">
                            <label for="profile_image">Profile Image</label>
                            <input class="form-control" id="profile_image" name="user_image" type="file">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update profile" name="update_profile" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php' ?>
<?php

if (isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];

    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];

    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_role = $_POST['user_role'];


    move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_image, role) VALUES ( ?, ?, ?, ?, ?, ?, ?)";

    $result = mysqli_execute_query($conn, $query, ["$username", "$user_password", "$user_firstname", "$user_lastname", "$user_email", "$user_image", "$user_role",]);

    confirm($result);
}

?>


<form action="#" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <h5>
            <label>Role</label>
        </h5>
        <select name="user_role" id="user_role">
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input class="form-control" id="username" name="username" type="text">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input class="form-control" id="user_email" name="user_email" type="email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input class="form-control" id="user_password" name="user_password" type="password">
    </div>
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input class="form-control" id="user_firstname" name="user_firstname" type="text">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input class="form-control" id="user_lastname" name="user_lastname" type="text">
    </div>
    <div class="form-group">
        <label for="profile_image">Profile Image</label>
        <input class="form-control" id="profile_image" name="user_image" type="file">
    </div>
    <div class="form-group">
        <input type="submit" value="Publish" name="create_user" class="btn btn-primary">
    </div>
</form>
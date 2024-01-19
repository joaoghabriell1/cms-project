<?php

if (isset($_POST['edit_user'])) {
    $user_id = $_GET['user_id'];
    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];

    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];

    $user_email = $_POST['user_email'];
    $user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
    $user_role = $_POST['user_role'];


    move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "UPDATE users SET username = ?, user_password = ?, user_firstname = ?, user_lastname = ?, user_email = ?, user_image = ?, role = ? WHERE user_id = ?";

    $result = mysqli_execute_query($conn, $query, ["$username", "$user_password", "$user_firstname", "$user_lastname", "$user_email", "$user_image", "$user_role", "$user_id"]);

    confirm($result);

    if ($result) {
        header('Location: users.php');
    }
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
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

<form action="#" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <h5>
            <label>Role</label>
        </h5>
        <select name="user_role" id="user_role">
            <option <?php echo $user_role === 'admin ' ? 'selected' : '' ?> value="admin">Admin</option>
            <option <?php echo $user_role === 'subscriber ' ? 'selected' : ''  ?> value="subscriber">Subscriber</option>
        </select>
    </div>
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
        <input type="submit" value="Publish" name="edit_user" class="btn btn-primary">
    </div>
</form>
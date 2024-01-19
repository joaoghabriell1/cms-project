<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<?php

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $server_error_message = null;
    $userinput_validation_message = null;

    if ($password === '' || $username === '' || $user_email === '') {
        $userinput_validation_message = 'No fields can be empty, please provide all the informations.';
    } else {
        try {
            $query = 'INSERT INTO users (username, user_email, user_password, role) VALUES (?, ?, ?, "admin")';

            $result = mysqli_execute_query($conn, $query, ["$username", "$user_email", "$password"]);

            if ($result) {
                header('Location: index.php');
            }
        } catch (Exception $e) {
            $code_error =  $e->getCode();

            if ($code_error === 1062) {
                $server_error_message = 'The user or email provided are already being used, please try again.';
            }
        }
    }
}

?>

<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <span>
                        <?php echo isset($server_error_message) ? $server_error_message : null ?>
                    </span>
                    <span>
                        <?php echo isset($userinput_validation_message) ? $userinput_validation_message : null ?>
                    </span>
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="user_email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>

    <?php include "includes/footer.php"; ?>
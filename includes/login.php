<?php session_start() ?>
<?php include 'db.php' ?>
<?php include '../admin/functions.php' ?>

<?php


if (isset($_POST['login'])) {

    $user_login_input = $_POST['user_login'];
    $password_input = $_POST['password'];

    $user_login_input =  mysqli_real_escape_string($conn, $user_login_input);

    $password_input =  mysqli_real_escape_string($conn, $password_input);

    $query = 'SELECT * FROM users WHERE username = ? OR user_email = ?';

    $result = mysqli_execute_query($conn, $query, ["$user_login_input", "$user_login_input"]);

    if (!$result) {
        die("QUERY FAILED" . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) === 0) {
        header('Location: /cms-project/index.php?user_login_incorrect=true');
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_id = $row['user_id'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $role = $row['role'];
            echo $username;
        }

        $password_is_correct = password_verify($password_input, $user_password);

        if ($password_is_correct) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_firstname'] = $user_firstname;
            $_SESSION['user_lastname'] = $user_lastname;
            $_SESSION['role'] = $role;

            header('Location: /cms-project/admin/index.php');
        } else {
            header("Location: /cms-project/index.php?password_incorrect=true");
        }
    }
}

?>



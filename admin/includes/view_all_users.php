<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = 'SELECT * FROM users';
        $result = mysqli_execute_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['role'];

            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";
            echo "<td>$user_email</td>";
            echo "<td>$user_role</td>";
            echo $user_role === 'admin' ? "<td><a href='users.php?downgrade=$user_id'>downgrade role</a></td>" : "<td><a href='users.php?upgrade=$user_id'>upgrade role</a></td>";
            echo "<td><a href='users.php?source=edit_user&user_id=$user_id'>Edit</a></td>";
            echo "<td><a onClick =\"javascript: return confirm('Procede to delete the user?') \" href='users.php?delete=$user_id'>Delete</a></td>";
            echo "<tr>";
        }
        ?>
    </tbody>

</table>

<?php
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $query = 'DELETE FROM users WHERE user_id = ?';
    $result = mysqli_execute_query($conn, $query, ["$user_id"]);

    confirm($result);

    if ($result) {
        header('Location: users.php');
    }
}

if (isset($_GET['upgrade'])) {
    $user_id = $_GET['upgrade'];
    $query = 'UPDATE users SET role = "admin" WHERE user_id = ?';

    $result = mysqli_execute_query($conn, $query, ["$user_id"]);

    confirm($result);

    if ($result) {
        header('Location: users.php');
    }
}

if (isset($_GET['downgrade'])) {
    $user_id = $_GET['downgrade'];
    $query = 'UPDATE users SET role = "subscriber" WHERE user_id = ?';

    $result = mysqli_execute_query($conn, $query, ["$user_id"]);

    confirm($result);

    if ($result) {
        header('Location: users.php');
    }
}


?>
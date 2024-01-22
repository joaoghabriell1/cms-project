<div class="col-md-4">
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="POST">
            <div class=" input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <input name="submit" class="btn btn-default" value="search" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                    </input>
                </span>
            </div>
        </form>
    </div>
    <div class="well">
        <h4>Login</h4>
        <form action="includes/login.php" method="POST">
            <div class="form-group">
                <input name="user_login" type="text" placeholder='Insert your username or email' class="form-control">
            </div>
            <div class="form-group">
                <input name="password" type="password" placeholder="Insert your password" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" name="login" type="submit">login</button>
            </div>
        </form>
    </div>

    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php
                    $query = "SELECT * FROM categories LIMIT 4";

                    $result = mysqli_execute_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['id'];
                        echo "<li><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php include 'widget.php' ?>
</div>
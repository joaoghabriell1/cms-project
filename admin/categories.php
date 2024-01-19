<?php include 'includes/admin_header.php' ?>
<div id="wrapper">
    <?php include 'includes/admin_navigation.php' ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Blank Page
                        <small>Subheading</small>
                    </h1>
                    <div class="col-xs-6">
                        <?php
                        if (isset($_POST['submit'])) {
                            $cat_title = $_POST['cat_title'];

                            if ($cat_title === '' || empty($cat_title)) {
                                echo 'This field should not be empty';
                            } else {
                                $query = 'INSERT INTO categories (cat_title)  VALUES  (?)';
                                $result = mysqli_execute_query($conn, $query, ["$cat_title"]);

                                if (!$result) {
                                    die('Query failed' . mysqli_error($conn));
                                }
                            }
                        }

                        if (isset($_GET['delete_cat'])) {
                            $cat_id = $_GET['delete_cat'];
                            $query = 'DELETE FROM categories WHERE id = ?';
                            $result = mysqli_execute_query($conn, $query, ["$cat_id"]);

                            if (!$result) {
                                die("It wasn't possible to delete the category from the database");
                            }
                        }

                        if (isset($_GET['edit_cat'])) {
                            $cat_id = $_GET['edit_cat'];
                            $edit_title = $_GET['cat_title'];
                        }

                        if (isset($_POST['edit_submit'])) {
                            $cat_id = $_GET['cat_id'];
                            $cat_title = $_POST['cat_title'];

                            $query = 'UPDATE categories SET cat_title = ? WHERE id = ?;';

                            $result = mysqli_execute_query($conn, $query, ["$cat_title", "$cat_id"]);
                        }
                        ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="cat_title">Title</label>
                                <input class="form-control" id="cat_title" name="cat_title" type="text">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add category">
                            </div>
                        </form>
                        <?php
                        if (isset($_GET['edit_cat'])) {
                        ?>
                            <form method="POST" action="categories.php?cat_id=<?php echo $_GET['edit_cat'] ?>">
                                <div class="form-group">
                                    <label for="cat_title">Title</label>
                                    <input class="form-control" id="cat_title" name="cat_title" type="text" value="<?php echo isset($edit_title) ? $edit_title : '' ?>">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="edit_submit" value="Edit category">
                                </div>
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM categories LIMIT 4";

                                $result = mysqli_execute_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['id'];
                                    echo "<tr>";
                                    echo "<td>$cat_id</td>";
                                    echo "<td>$cat_title</td>";
                                    echo "<td><a href='categories.php?delete_cat=$cat_id'>delete</a></td>";
                                    echo "<td><a href='categories.php?edit_cat=$cat_id&cat_title=$cat_title'>edit</a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php' ?>
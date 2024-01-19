<?php include 'includes/admin_header.php' ?>
<div id="wrapper">
    <?php include 'includes/admin_navigation.php' ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Posts
                    </h1>
                    <?php
                    $source = '';
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    }
                    switch ($source) {
                        case 'add_user':
                            include 'includes/add_user.php';
                            break;
                        case 'edit_user':
                            include 'includes/edit_user.php';
                            break;
                        default:
                            include 'includes/view_all_users.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php' ?>
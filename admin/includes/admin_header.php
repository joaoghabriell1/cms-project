<?php session_start() ?>
<?php ob_start(); ?>

<?php include '../includes/db.php' ?>
<?php include 'functions.php' ?>

<?php


if (!isset($_SESSION['role'])) {
    header('Location: /cms-project/index.php?role_not_defined=true');
}

if (isset($_SESSION['role'])) {

    $user_is_admin = $_SESSION['role'] == 'admin';

    if (!$user_is_admin) {
        header('Location: /cms-project/index.php?user_isnot_admin=true');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css?v=1" rel="stylesheet">
    <link href="css/styles.css?v=1" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/summernote.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body>
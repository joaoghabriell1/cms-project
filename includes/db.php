<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'localhost');
define('DB_PASSWORD', '');
define('DB_NAME', 'cms');
define('DB_PORT', '3307');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

if (!$conn) {
    die('It wasnt possible to connect to the database' . mysqli_connect_error());
}

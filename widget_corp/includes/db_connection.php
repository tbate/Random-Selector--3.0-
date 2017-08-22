<?php
    define("DB_SERVER", "localhost");
    define("DB_USER", "lord_commander");
    define("DB_PASS", "DiviSion/Of1!");
    define("DB_NAME", "random_selector");

    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if(mysqli_connect_errno())
    {
        die('Database connection failed: ' . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }
?>
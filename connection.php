<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login_test_db";

if(!$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname))
{
    die("Failed To connect");
}

?>
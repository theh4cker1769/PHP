<?php
session_start();

    include("connection.php");
    include("functions.php");


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //something was posted

        $username = $_POST['user_name'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password) && !is_numeric($username))
        {
            //save to database

            $user_id = random_num(20);
            $query = "insert into users (user_id, username, password) values ('$user_id', '$username', '$password')";

            mysqli_query($conn, $query);
            header("Location: login.php");
            die;
        }
        else
        {
            echo 'Please Enter Valid Information';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    <form method="POST">
        <input type="text" placeholder="username" name="user_name">
        <input type="password" placeholder="password" name="password">
        <input type="submit" value="Sign Up">

        <a href="login.php">Login</a>
    </form>
</body>
</html>
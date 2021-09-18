<?php
session_start();

    include("connection.php");
    include("functions.php");


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //something was posted
        $name = $_POST['name'];
        $username = $_POST['user_name'];
        $email = $_POST['email'];
        $phoneno = $_POST['phoneno'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password) && !is_numeric($username))
        {
            //save to database


            $usernamequery = "select * from users where username = '$username'";

            $userresult = mysqli_query($conn, $usernamequery);

            if (mysqli_num_rows($userresult) > 0) {
                echo 'Username is already there';
            }
            else{
                $user_id = random_num(20);
                $query = "insert into users (user_id, name, username, email, phoneno, password) values ('$user_id', '$name', '$username', '$email', '$phoneno', '$password')";
                mysqli_query($conn, $query);
                header("Location: login.php");
                die;
            }
            
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
        <input type="text" placeholder="Name" name="name">
        <input type="text" placeholder="Username" name="user_name">
        <input type="email" placeholder="Email" name="email" required>
        <input type="tel" placeholder="Phone No" name="phoneno">
        <input type="password" placeholder="Password" name="password">
        <input type="submit" value="Sign Up">

        
    </form>
    <a href="login.php">Login</a>
</body>
</html>
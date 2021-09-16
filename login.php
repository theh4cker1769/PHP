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
        //read database

        $query = "select * from users where username = '$username' limit 1";

        $result = mysqli_query($conn, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);

                if($user_data['password'] === $password)
                {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        echo '<script>alert("Wrong Password");</script>';
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
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form method="POST">

        <input type="text" placeholder="username" name="user_name">
        <input type="password" placeholder="password" name="password">
        <input type="submit" value="Login">

        <a href="signup.php">Sign UP</a>
    </form>
</body>

</html>
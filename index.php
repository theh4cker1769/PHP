<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {

        $userid = $_SESSION['user_id'];
        $message = $_POST['commentmsg'];
        $getname = "select name from users where user_id = '$userid'";
        $result = mysqli_query($conn, $getname);

        if ($result) {
            $row = mysqli_fetch_array($result);
            $name = $row['name'];
        }

        $query = "insert into comments (name, message) values('$name', '$message')";
        mysqli_query($conn, $query);

    }
    else {
        echo '<script>alert("Please Login")</script>';
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <a href="logout.php">Logout</a>
    <h1>Hello World From Israel and Harshavardhan Reddy</h1>
    <h2>Hello <?php echo $user_data['username'];  ?> </h2>

    <img src="images/tree-736885__480.jpg" alt="Image">
    <form action="" method="post">
        <textarea name="commentmsg" cols="30" rows="10" placeholder="Comment"></textarea>
        <input type="submit" value="Submit">
    </form>
    
    <?php
        getComments($conn);
    ?>
</body>

</html>
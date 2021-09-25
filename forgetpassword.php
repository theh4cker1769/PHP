<?php
session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $usernamefor = $_POST['usernamefor'];
    $query = "select * from users where username = '$usernamefor' ";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);


        $to_email = $row['email'];
        $subject = "Forget Password";
        $body = $row['password'];
        $headers = "From: reddy.har2002@gmail.com";

        if (mail($to_email, $subject, $body, $headers)) {
            echo "Email successfully sent to $to_email...";
        } else {
            echo "Email sending failed...";
        }

        if(true)
        {
            echo "<script>alert('Password Send to your Email');</script>";
            header("Location: login.php");
        }
    }
    else
    {
        header("Location: signup.php");
        die;
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <h1>Forget Password</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])  ?>" method="POST">

        <input type="text" placeholder="Enter Username" name="usernamefor">
        <input type="submit" value="Send OTP">
    </form>
</body>

</html>
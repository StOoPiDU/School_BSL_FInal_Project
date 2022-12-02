<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: November 18, 2022
 * Description: Login page for Final Project
 */
require_once('connect.php');
//require_once('session.php');

$errorMessage = '';

if(!isset($_GET['signup']))
{

}
else
{
    $signupCheck = $_GET['signup'];

    if($signupCheck = "password")
    {
        $errorMessage = "Incorrect Password";
    }
    elseif($signupCheck = "fail")
    {
        $errorMessage = "Login failed";
    }
    elseif($signupCheck == "empty")
    {
        $errorMessage = "Please enter your details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Best Soccer League - Login</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css"/>
    <script>
    function valid()
    {
        var validated = true;
        var username = document.getElementById('username');
        var password = document.getElementById('password');

        if(username.value === "" && password.value === "")
        {
            document.getElementById('message').innerHTML = "Please enter your username and password.";
            document.getElementById('message').style.display = "block";
            validated = false;
        }
        else if(username.value === "" && password.value != "")
        {
            document.getElementById('message').innerHTML = "Please enter your username.";
            document.getElementById('message').style.display = "block";
            validated = false;
        }
        else if(username.value != "" && password.value === "")
        {
            document.getElementById('message').innerHTML = "Please enter your password.";
            document.getElementById('message').style.display = "block";
            validated = false;
        }

        return validated;
    }
    </script>
</head>
<body>
    <form action="login_process.php" method="POST">
    <input type="text" class="form-control" name="username" placeholder="username" id="username">
    <input type="password" class="form-control" name="password" placeholder="password" id="password">

    <label class="error" id="message"></label>
    <label class="error"><?= $errorMessage?></label>

    <button type="submit" value="login" onclick="return valid()">Login</button>
    </form>
    <a href="index.php">Home</a>
    <a href="signup.php">Sign up</a>
</body>
</html>
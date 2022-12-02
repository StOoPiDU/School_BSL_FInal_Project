<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: November 18, 2022
 * Description: Signup page for Final Project
 */
require_once('connect.php');
//require_once('session.php');

if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirmpassword']))
{
    $errorMessage = "Empty fields";
    echo $errorMessage;
}
else
{
    if(($_POST['password']) == ($_POST['confirmpassword']))
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (username, password) value (:username, :password)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username',$username);
        $statement->bindValue(':password',$password);
        $statement->execute();

        header("Location:login.php");
    }
    else
    {
        $errorMessage = "Passwords do not match.";

        echo $errorMessage;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Best Soccer League - Sign Up</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css"/>
</head>
<body>
    <form action='#' method="POST">
        <ul>
            <li>
                <label>Username:</label>
                <input type="text" name="username" placeholder="Enter Username">
            </li>
            <li>
                <label>Password:</label>
                <input type="password" name="password">
            </li>
            <li>
                <label>Confirm Password:</label>
                <input type="password" name="confirmpassword">
            </li>
            <li>
                <button>Sign Up</button>
            </li>
        </ul>
    </form>
    <a href="index.php">Home</a> <a href="login.php">Login</a>
</body>
</html>
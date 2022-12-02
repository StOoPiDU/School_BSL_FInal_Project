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
    if(isset($_POST['username']))
    {



        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if(isset($username) && isset($password))
        {
            $query = "SELECT user_id, admin, username, password FROM user WHERE active=1 AND username ='$username'";
    
            $statement = $db->prepare($query);
            $statement->execute();
            $row = $statement->fetch();
    
            if($statement->rowCount() != 0)
            {
                $dbPassword = $row['password'];
                if(password_verify($password, $dbPassword))
                {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['admin'] = $row['admin'];
                    header("Location:index.php?success=yes");
                }
                else
                {
                    $errormsg="Incorrect Password!";
                }
            }
            else
            {
                $errormsg="Account disabled or does not exist!";
            }
    
        }
        else
        {
            $errormsg="Account and/or Password not entered!";
        }


    }
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
<?php if(isset($errormsg)){ ?>
    <p><?=$errormsg?></p>
<?php } ?>
    <form action="#" method="POST">
    <input type="text" class="form-control" name="username" placeholder="username" id="username">
    <input type="password" class="form-control" name="password" placeholder="password" id="password">

    <label class="error" id="message"></label>
    <label class="error"><?= $errorMessage?></label>

    <button type="submit" value="login" onclick="return valid()">Login</button>
    </form>
    <a href="index.php">Home</a>
    <a href="signup.php">Register</a>
</body>
</html>
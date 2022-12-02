<?php
    
    require_once('connect.php');
    //require_once('session.php');

    //$_SESSION['user_id'] = "";

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(isset($username) && isset($password))
    {
        $query = "SELECT * FROM user WHERE username ='$username'";

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
                header("Location:index.php?success=yes");
            }
            else
            {
                header("Location:login.php?signup=password");
            }
        }
        else
        {
            header("Location:login.php?signup=fail");
        }

    }
    else
    {
        header("Location:login.php?signup=empty");
    }
?>
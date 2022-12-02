<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: December 1, 2022
 * Description: Session file Final Project
 */
    require_once('connect.php');
    global $db;
    session_start();

    if(isset($_SESSION['user_id']))
    {
        $sessionUser = $_SESSION['user_id'];

        $query = "SELECT * FROM user WHERE user_id = '$sessionUser'";
        $statement = $db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();

        $_SESSION['admin'] = $row['admin'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        if($row['admin'] = 1)
        {
            
        }
    }
?>